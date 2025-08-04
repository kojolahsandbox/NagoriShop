<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SellerController extends Controller
{
    // ... (method index, create, edit, destroy tetap sama seperti sebelumnya) ...

    /**
     * Menyimpan data penjual baru ke database.
     */
    public function store(Request $request)
    {
        // --- AWAL PERUBAHAN ---
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'address' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,
            'address' => $request->address,
            'role' => 'seller',
        ]);
        // --- AKHIR PERUBAHAN ---

        return redirect()->route('sellers.index')->with('success', 'Penjual baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data penjual di database.
     */
    public function update(Request $request, User $seller)
    {
        // --- AWAL PERUBAHAN ---
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($seller->id)],
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'address' => 'required|string|max:255',
        ]);

        $seller->fill($request->only([
            'name',
            'email',
            'phone',
            'status',
            'province',
            'city',
            'district',
            'village',
            'address'
        ]));

        if ($request->filled('password')) {
            $seller->password = Hash::make($request->password);
        }

        $seller->save();
        // --- AKHIR PERUBAHAN ---

        return redirect()->route('sellers.index')->with('success', 'Data penjual berhasil diperbarui.');
    }

    // ... (method index, create, edit, destroy lainnya tidak berubah) ...
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'seller');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('sellers.edit', $row->id);
                    $deleteUrl = route('sellers.destroy', $row->id);

                    $editBtn = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></a>';

                    $deleteBtn = '<form action="' . $deleteUrl . '" method="POST" style="display:inline;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus penjual ini?\')"><i class="fas fa-trash"></i></button>'
                        . '</form>';

                    return $editBtn . $deleteBtn;
                })
                ->addColumn('status', function ($user) {
                    if ($user->status == 'active') {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-secondary">Tidak Aktif</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('administrator.sellers.index');
    }
    public function create()
    {
        return view('administrator.sellers.create');
    }
    public function edit(User $seller)
    {
        // Pastikan hanya user dengan role 'seller' yang bisa diedit melalui route ini
        if ($seller->role !== 'seller') {
            abort(404);
        }
        return view('administrator.sellers.edit', compact('seller'));
    }
    public function destroy(User $seller)
    {
        if ($seller->role !== 'seller') {
            return redirect()->route('sellers.index')->with('error', 'Aksi tidak diizinkan.');
        }

        $seller->delete();

        return redirect()->route('sellers.index')->with('success', 'Penjual berhasil dihapus.');
    }
}