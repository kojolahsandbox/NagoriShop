<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman daftar pesanan untuk administrator.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user')->select('orders.*');

            return DataTables::of($data)
                ->addIndexColumn() // <-- TAMBAHKAN BARIS INI untuk penomoran
                ->addColumn('customer_name', function ($row) {
                    return $row->user ? $row->user->name : 'Pelanggan Dihapus';
                })
                ->addColumn('total_amount', function ($row) {
                    return 'Rp' . number_format($row->total_amount, 0, ',', '.');
                })
                ->addColumn('status_badge', function ($row) {
                    return $this->getStatusBadge($row->status);
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return $row->created_at->format('d M Y, H:i');
                })
                ->addColumn('action', function ($row) {
                    $detailUrl = route('orders.show', $row->id);
                    return '<a href="' . $detailUrl . '" class="btn btn-info btn-sm">Detail & Proses</a>';
                })
                ->rawColumns(['action', 'status_badge'])
                ->make(true);
        }

        return view('administrator.orders.index');
    }

    /**
     * Menampilkan halaman detail pesanan untuk diproses.
     */
    public function show(Order $order)
    {
        // Eager load relasi yang dibutuhkan
        $order->load('user', 'orderItems.product');
        $data = [
            'title' => 'Detail Pesanan #' . $order->user->name,
            'order' => $order,
        ];

        return view('administrator.orders.show', $data);
    }

    /**
     * Mengupdate pesanan (ongkir dan status).
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'shipping_fee' => 'required|numeric|min:0',
            'status' => 'required|in:draft,waiting_payment,paid,shipped,completed,cancelled',
        ]);

        // Update biaya ongkir dan status
        $order->shipping_fee = $request->shipping_fee;
        $order->status = $request->status;

        // Jika ongkir sudah diisi, anggap pengiriman sudah dikonfirmasi
        if ($request->shipping_fee > 0 && $order->shipping_status == 'pending') {
            $order->shipping_status = 'confirmed';
        }

        // Hitung ulang total pembayaran
        $subtotal = $order->orderItems->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $service_fee = ($subtotal + $order->shipping_fee) * 0.01;
        $order->total_amount = $subtotal + $order->shipping_fee + $service_fee;

        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Helper function untuk membuat badge status.
     */
    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'draft':
                return '<span class="badge badge-secondary">Menunggu Konfirmasi</span>';
            case 'waiting_payment':
                return '<span class="badge badge-warning">Menunggu Pembayaran</span>';
            case 'paid':
                return '<span class="badge badge-primary">Dibayar (Siap Dikemas)</span>';
            case 'shipped':
                return '<span class="badge badge-info">Dikirim</span>';
            case 'completed':
                return '<span class="badge badge-success">Selesai</span>';
            case 'cancelled':
                return '<span class="badge badge-danger">Dibatalkan</span>';
            default:
                return '<span class="badge badge-light">Tidak Diketahui</span>';
        }
    }
}