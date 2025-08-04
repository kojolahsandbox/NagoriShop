<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use App\Mail\ConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Qris;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class CheckoutController extends Controller
{
    //
    public function confirmation(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if (!$validatedData) {
            return redirect()->route('profile')->with('alert', 'Terjadi kesalahan saat pembelian langsung');
        }

        if (!auth()->user()->province || !auth()->user()->city || !auth()->user()->district || !auth()->user()->village) {
            return redirect()->route('profile')->with('alert', 'Silahkan isi alamat Profil anda terlebih dahulu');
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $variantId = $request->variant_id;

        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if ($variant) {
            $variantStock = $variant->stock;
            if ($variantStock < $quantity) {
                return redirect()->route('profile')->with('alert', 'Stok Varian Produk yang dipilih Kurang!');
            }
        } else {
            $productStock = $product->stock;
            if ($productStock < $quantity) {
                return redirect()->route('profile')->with('alert', 'Stok Produk yang dipilih Kurang!');
            }
        }

        $order = Order::where('user_id', auth()->user()->id)
            ->where('status', 'waiting_payment')
            ->first();
        if ($order) {
            return redirect()->route('profile')->with('alert', 'Anda masih memiliki pesanan yang belum dibayar!');
        }

        if (!$product) {
            return view('404');
        } else {
            if ($variant) {
                // Cart::create([
                //     'user_id' => auth()->user()->id,
                //     'product_id' => $productId,
                //     'quantity' => $quantity,
                //     'variant_id' => $variantId,
                // ]);
                $unit_price = $variant->price;
                $total_amount = $variant->price * $quantity;
            } else {
                // Cart::create([
                //     'user_id' => auth()->user()->id,
                //     'product_id' => $productId,
                //     'quantity' => $quantity,
                //     'variant_id' => null,
                // ]);
                $unit_price = $product->price;
                $total_amount = $product->price * $quantity;
            }

            $province = Province::find(auth()->user()->province);
            $city = Regency::find(auth()->user()->city);
            $district = District::find(auth()->user()->district);
            $village = Village::find(auth()->user()->village);
            $address = auth()->user()->address . ', ' . $village->name . ', ' . $district->name . ', ' . $city->name . ', ' . $province->name;

            $newAddress = Address::create([
                'user_id' => auth()->user()->id,
                'recipient_name' => auth()->user()->name,
                'phone' => auth()->user()->phone,
                'address_text' => $address,
                'is_default' => 1
            ]);

            $newAddressId = $newAddress->id;

            $newOrder = Order::create([
                'user_id' => auth()->user()->id,
                'address_id' => $newAddressId,
                'shipping_fee' => '0',
                'shipping_status' => 'pending',
                'payment_method' => 'qris',
                'note' => null,
                'status' => 'draft',
                'total_amount' => $total_amount
            ]);

            $newOrderId = $newOrder->id;

            OrderItem::create([
                'order_id' => $newOrderId,
                'product_id' => $productId,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'variant' => $variant ? $variant->variant : '',
            ]);


            if ($variant) {
                $newStock = $variant->stock - $quantity;
                $variant->update([
                    'stock' => $newStock
                ]);
                $variant->save();
            } else {
                $newStock = $product->stock - $quantity;
                $product->update([
                    'stock' => $newStock
                ]);
                $product->save();
            }

            // mail to seller
            $mailData = [
                'seller' => $product->seller->name,
                'order_id' => $newOrderId,
                'title' => 'Konfirmasi Pesanan Pelanggan',
                'body' => 'Konfirmasi Pesanan Pelanggan atas nama ' . auth()->user()->name .
                    ' yaitu: ' . $product->name .
                    ' sebanyak ' . $quantity .
                    ($variant ? ' dengan varian ' . $variant->variant : '')
            ];


            Mail::to($product->seller->email)->send(new ConfirmationMail($mailData));

            return redirect()->route('profile')->with('success', 'Pesanan anda berhasil dibuat!');
        }

    }

    public function checkout($id)
    {
        $order = Order::find($id);
        $qris = Qris::where('order_id', $id)->first();

        if (!$order) {
            return view('404');
        } else {
            $orderItems = $order->orderItems;

            $data = [
                'title' => 'Checkout',
                'order' => $order,
                'orderItems' => $orderItems,
                'qris' => $qris,
                'address' => Address::find($order->address_id),
            ];

            return view('customer.checkout', $data);
        }
    }

    public function generateQris($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return view('404');
        } else {

            // Parameter untuk request
            $nota = 'ORD' . $order->created_at->format('ymHis');

            $params = [
                'do' => 'create-invoice',
                'apikey' => env('QRIS_API_KEY'), // API Key dari .env
                'mID' => env('QRIS_MID'), // Merchant ID dari .env
                'cliTrxNumber' => $nota, // Nomor transaksi unik
                'cliTrxAmount' => intval($order->total_amount), // Jumlah transaksi + kode unik
                'useTip' => 'no',
            ];

            // API QRIS 
            $url = "https://qris.interactive.co.id/restapi/qris/show_qris.php";

            $response = Http::get($url, $params);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['data']) && is_array($responseData['data'])) {

                    $data = $responseData['data'];

                    $qris = Qris::create([
                        'order_id' => $id,
                        'qris_content' => $data['qris_content'],
                        'qris_request_date' => $data['qris_request_date'],
                        'qris_invoiceid' => $data['qris_invoiceid'],
                        'qris_invoiceamount' => intval($order->total_amount),
                        'qris_invoicestatus' => 'unpaid',
                    ]);

                    $order->update([
                        'status' => 'waiting_payment',
                    ]);
                    $order->save();

                    return redirect()->route('checkout', $id);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data QRIS dari API',
                ], 500);
            }

        }
    }

    public function checkPayment($id)
    {
        $qris = Qris::find($id);

        if (!$qris) {
            return view('404');
        } else {
            $params = [
                'do' => 'checkStatus',
                'apikey' => env('QRIS_API_KEY'),
                'mID' => env('QRIS_MID'),
                'invid' => $qris->qris_invoiceid,
                'trxvalue' => $qris->qris_invoiceamount,
                'trxdate' => date('Y-m-d', \Carbon\Carbon::parse($qris->qris_request_date)->timestamp),
            ];

            $url = "https://qris.interactive.co.id/restapi/qris/checkpaid_qris.php";

            $response = Http::get($url, $params);
            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] == 'failed') {
                    return redirect()->route('checkout', $qris->order_id)->with('alert', 'Pembayaran Gagal/Belum Dilakukan! Silahkan Coba Lagi');
                }

                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    $data = $responseData['data'];
                    $qris->update([
                        'qris_invoicestatus' => $data['qris_status'],
                    ]);
                    $qris->save();

                    if ($data['qris_status'] == 'paid') {
                        $order = Order::find($qris->order_id);
                        $order->update([
                            'status' => 'paid',
                        ]);
                        $order->save();
                    }
                    return redirect()->route('profile')->with('success', 'Pembayaran berhasil! Barang Akan Segera Dikirim');
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data QRIS dari API',
                ], 500);
            }
        }
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return view('404');
        } else {
            $order->update([
                'status' => 'cancelled'
            ]);
            $order->save();
            return redirect()->route('profile')->with('alert', 'Pembelian Berhasil dibatalkan!');
        }
    }

    public function cart()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.seller', 'variant']) // eager load relasi
            ->get()
            ->map(function ($item) {
                $product = $item->product;
                $variant = $item->variant;

                return [
                    'id' => $item->id,
                    'shopName' => $product->seller->name ?? 'Kodai Nagori',
                    'title' => $product->name ?? 'Nama Produk',
                    'product_id' => $product->id ?? 'Id Produk',
                    'variant' => $variant->variant ?? 'Tidak Ada Varian', // 'variant' adalah nama di tabel product_variants
                    'variant_id' => $item->variant_id,
                    'price' => $product->price,
                    'originalPrice' => ($variant && $variant->price)
                        ? $variant->price * $item->quantity
                        : $product->price * $item->quantity,
                    'discount' => 0,
                    'quantity' => $item->quantity,
                    'image' => asset('storage/products/' . $product->image) ?? 'https://www.claudeusercontent.com/api/placeholder/80/80',
                    'selected' => false,
                    'tags' => []
                ];
            });

        $data = [
            'cartItems' => $cartItems,
            'title' => 'Keranjang Belanja'
        ];

        return view('customer.cart', $data);
    }

    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if (!$validatedData) {
            return redirect()->route('profile')->with('alert', 'Terjadi kesalahan saat menambahkan produk ke keranjang.');
        }

        $user = User::find(auth()->user()->id);
        if (!$user->province || !$user->city || !$user->district || !$user->village) {
            return redirect()->route('profile')->with('alert', 'Silahkan isi alamat Profil anda terlebih dahulu');
        }

        $userId = auth()->id();
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $variantId = $request->variant_id;

        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if (!$product) {
            return view('404');
        }

        if ($variant) {
            $variantStock = $variant->stock;
            if ($variantStock < $quantity) {
                return redirect()->route('profile')->with('alert', 'Stok Varian Produk yang dipilih Kurang!');
            }
        } else {
            $productStock = $product->stock;
            if ($productStock < $quantity) {
                return redirect()->route('profile')->with('alert', 'Stok Produk yang dipilih Kurang!');
            }
        }

        $order = Order::where('user_id', auth()->user()->id)
            ->where('status', 'waiting_payment')
            ->first();
        if ($order) {
            return redirect()->route('profile')->with('alert', 'Anda masih memiliki pesanan yang belum dibayar!');
        }
        // dd(Cart::where('user_id', $userId)
        //     ->where('product_id', $productId)
        //     ->where('variant_id', $variantId)
        //     ->toSql());
        // Cek apakah produk sudah ada di cart user
        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where(function ($query) use ($variantId) {
                if ($variantId) {
                    $query->where('variant_id', $variantId);
                } else {
                    $query->whereNull('variant_id');
                }
            })
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'variant_id' => $variantId, // <-- pakai variant_id
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('home')->with('success', 'Pesanan berhasil masuk keranjang!');

    }

    public function cartDelete($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return redirect()->route('cart')->with('alert', 'Pesanan tidak ditemukan');
        }

        $cart->delete();

        return redirect()->route('cart')->with('success', 'Pesanan berhasil dihapus');
    }

    public function checkoutCart(Request $request)
    {
        $data = $request->all();
        $checkoutData = json_decode($data['checkout_data'], true);
        $shop = $checkoutData['shop'];
        $items = $checkoutData['items'];
        $total = $checkoutData['total'];

        // Pastikan $items selalu dalam bentuk array
        if (!is_array($items) || isset($items['product_id'])) {
            $items = [$items];
        }

        if (!auth()->user()->province || !auth()->user()->city || !auth()->user()->district || !auth()->user()->village) {
            return redirect()->route('profile')->with('alert', 'Silahkan isi alamat Profil anda terlebih dahulu');
        }

        // Validasi stok semua item terlebih dahulu
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $variantId = $item['variant_id'];

            $product = Product::find($productId);
            $variant = ProductVariant::find($variantId);

            if (!$product) {
                return view('404');
            }

            if ($variant) {
                if ($variant->stock < $quantity) {
                    return redirect()->route('profile')->with('alert', 'Stok Varian Produk ' . $product->name . ' kurang!');
                }
            } else {
                if ($product->stock < $quantity) {
                    return redirect()->route('profile')->with('alert', 'Stok Produk ' . $product->name . ' kurang!');
                }
            }
        }

        // Cek apakah sudah ada order belum dibayar
        $order = Order::where('user_id', auth()->user()->id)
            ->where('status', 'waiting_payment')
            ->first();
        if ($order) {
            return redirect()->route('profile')->with('alert', 'Anda masih memiliki pesanan yang belum dibayar!');
        }

        // Buat address baru
        $province = Province::find(auth()->user()->province);
        $city = Regency::find(auth()->user()->city);
        $district = District::find(auth()->user()->district);
        $village = Village::find(auth()->user()->village);
        $address = auth()->user()->address . ', ' . $village->name . ', ' . $district->name . ', ' . $city->name . ', ' . $province->name;

        $newAddress = Address::create([
            'user_id' => auth()->user()->id,
            'recipient_name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'address_text' => $address,
            'is_default' => 1
        ]);

        $newOrder = Order::create([
            'user_id' => auth()->user()->id,
            'address_id' => $newAddress->id,
            'shipping_fee' => '0',
            'shipping_status' => 'pending',
            'payment_method' => 'qris',
            'note' => null,
            'status' => 'draft',
            'total_amount' => $total
        ]);

        $sellerItems = [];

        // Simpan item ke order
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $variant = ProductVariant::find($item['variant_id']);
            $quantity = $item['quantity'];

            $unit_price = $variant ? $variant->price : $product->price;
            $variant_name = $variant ? $variant->variant : '';

            OrderItem::create([
                'order_id' => $newOrder->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'variant' => $variant_name,
            ]);

            // Kurangi stok
            if ($variant) {
                $variant->decrement('stock', $quantity);
            } else {
                $product->decrement('stock', $quantity);
            }

            $sellerId = $product->seller->id;
            if (!isset($sellerItems[$sellerId])) {
                $sellerItems[$sellerId] = [
                    'seller_name' => $product->seller->name,
                    'seller_email' => $product->seller->email,
                    'items' => []
                ];
            }

            $sellerItems[$sellerId]['items'][] = [
                'product_name' => $product->name,
                'quantity' => $quantity,
                'variant' => $variant_name,
            ];
            // Kirim notifikasi email ke penjual
            // $mailData = [
            //     'seller' => $product->seller->name,
            //     'order_id' => $newOrder->id,
            //     'title' => 'Konfirmasi Pesanan Pelanggan',
            //     'body' => 'Konfirmasi Pesanan Pelanggan atas nama ' . auth()->user()->name .
            //         ' yaitu: ' . $product->name .
            //         ' sebanyak ' . $quantity .
            //         ($variant ? ' dengan varian ' . $variant->variant : '')
            // ];
            // Mail::to($product->seller->email)->send(new ConfirmationMail($mailData));

        }

        foreach ($sellerItems as $sellerData) {
            // 1. Buat string HTML ('body') dari daftar item untuk setiap penjual
            $bodyHtml = 'Pelanggan atas nama <b>' . auth()->user()->name . '</b> telah memesan item berikut:<br><br>';
            foreach ($sellerData['items'] as $item) {
                $bodyHtml .= '• Produk: <b>' . $item['product_name'] . '</b><br>';
                if (!empty($item['variant'])) {
                    $bodyHtml .= '&nbsp;&nbsp;&nbsp;Varian: ' . $item['variant'] . '<br>';
                }
                $bodyHtml .= '&nbsp;&nbsp;&nbsp;Jumlah: ' . $item['quantity'] . ' pcs<br><br>';
            }

            // 2. Siapkan data email dengan key 'body' yang diharapkan oleh Blade
            $mailData = [
                'seller' => $sellerData['seller_name'],
                'order_id' => $newOrder->id,
                'title' => 'Konfirmasi Pesanan Pelanggan',
                'body' => $bodyHtml // <-- 'body' sekarang berisi string HTML yang detail
            ];

            // 3. Kirim email
            Mail::to($sellerData['seller_email'])->send(new ConfirmationMail($mailData));
        }

        return redirect()->route('profile')->with('success', 'Pesanan anda berhasil dibuat!');
    }

}
