<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
// Hapus 'use Illuminate\Support\Facades\Storage;' karena tidak lagi digunakan
// use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Menampilkan halaman daftar pelanggan.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'customer')->select('id', 'name', 'email', 'phone', 'status');

            return DataTables::of($data)
                ->addColumn('avatar', function ($user) {
                    // --- AWAL PERUBAHAN ---
                    $name = $user->name;
                    $words = explode(' ', $name);
                    $initials = '';

                    // Ambil huruf pertama dari kata pertama
                    if (isset($words[0])) {
                        $initials .= strtoupper(substr($words[0], 0, 1));
                    }
                    // Ambil huruf pertama dari kata terakhir jika ada lebih dari satu kata
                    if (count($words) > 1) {
                        $initials .= strtoupper(substr(end($words), 0, 1));
                    } elseif (strlen($name) > 1) {
                        // Jika hanya satu kata, ambil dua huruf pertama
                        $initials = strtoupper(substr($name, 0, 2));
                    }

                    // Buat warna latar belakang acak yang konsisten berdasarkan nama
                    $colors = ['#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4', '#009688', '#4caf50', '#8bc34a', '#ff9800', '#ff5722', '#795548'];
                    $colorIndex = crc32($name) % count($colors);
                    $backgroundColor = $colors[$colorIndex];

                    // Buat HTML untuk avatar inisial
                    return '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: ' . $backgroundColor . '; color: white; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold;">'
                        . $initials
                        . '</div>';
                    // --- AKHIR PERUBAHAN ---
                })
                ->addColumn('status', function ($user) {
                    if ($user->status == 'active') {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-secondary">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('customers.destroy', $row->id);
                    $csrfToken = csrf_field();

                    $deleteBtn = '<form action="' . $deleteUrl . '" method="POST" style="display:inline;">'
                        . $csrfToken
                        . '<input type="hidden" name="_method" value="DELETE">'
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus pelanggan ini?\')"><i class="fas fa-trash"></i></button>'
                        . '</form>';

                    return $deleteBtn;
                })
                ->rawColumns(['action', 'avatar', 'status'])
                ->make(true);
        }

        return view('administrator.customers.index');
    }

    /**
     * Menghapus data pelanggan dari database.
     */
    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            return redirect()->route('customers.index')->with('error', 'Aksi tidak diizinkan.');
        }

        // --- AWAL PERUBAHAN ---
        // Menghapus logika pengecekan dan penghapusan file avatar karena tidak relevan lagi
        /* if ($customer->avatar && Storage::disk('public')->exists('avatars/' . $customer->avatar)) {
            Storage::disk('public')->delete('avatars/' . $customer->avatar);
        }
        */
        // --- AKHIR PERUBAHAN ---

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}