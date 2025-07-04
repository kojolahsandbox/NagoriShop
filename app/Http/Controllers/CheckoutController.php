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
use App\Models\Village;
use App\Mail\ConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    //
    public function confirmation(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $variantId = $request->variant_id;

        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if (!$product) {
            return view('404');
        } else {
            if ($variant) {
                Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'variant' => $variantId,
                ]);
                $unit_price = $variant->price;
                $total_amount = $variant->price * $quantity;
            } else {
                Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'variant' => null,
                ]);
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
}
