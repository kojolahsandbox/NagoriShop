<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->with(['orderItems.product']) // Menyertakan relasi orderItems dan product
            ->get();

        $purchasedItems = [];

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $idByDate = 'ORD' . $order->created_at->format('ymHis');
                $purchasedItems[] = [
                    'id' => $idByDate,
                    'order_id' => $order->id,
                    'product' => $item->product_name,
                    'price' => 'Rp' . number_format($order->total_amount, 0, ',', '.'),
                    'status' => $this->getStatusText($order->status),
                    'statusLabel' => $this->getStatusLabel($order->status),
                    'date' => $order->created_at->format('d M Y'),
                    'image' => $item->product ? asset('storage/products/' . $item->product->image) : 'https://www.claudeusercontent.com/api/placeholder/50/50',
                ];
            }
        }

        $data = [
            'title' => 'Profil',
            'purchasedItems' => $purchasedItems,
        ];

        return view('customer.profile', $data);
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 'draft':
                return 'Menunggu Konfirmasi';
            case 'waiting_payment':
                return 'Menunggu Pembayaran';
            case 'paid':
                return 'Dikemas';
            case 'shipped':
                return 'Diperjalanan';
            case 'completed':
                return 'Terkirim';
            case 'cancelled':
                return 'Dibatalkan';
            default:
                return 'Status Tidak Diketahui';
        }
    }

    private function getStatusLabel($status)
    {
        switch ($status) {
            case 'draft':
                return 'pending';
            case 'waiting_payment':
                return 'pending';
            case 'paid':
                return 'shipped';
            case 'shipped':
                return 'shipped';
            case 'completed':
                return 'delivered';
            case 'cancelled':
                return 'Dibatalkan';
            default:
                return 'Status Tidak Diketahui';
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // ubah no hp dari 08 atau 628 menjadi 628 semuanya 
        $phone = $request->phone;
        if (substr($phone, 0, 2) == '08') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) == '628') {
            $phone = '62' . substr($phone, 3);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $phone;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->district = $request->district;
        $user->village = $request->village;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil Berhasil diperbaharui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('profile')->with('success', 'Password Berhasil diperbaharui!');
        } else {
            return redirect()->route('profile')->with('alert', 'Password lama ini salah!');
        }
    }
}
