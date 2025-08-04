<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Cek jika request adalah AJAX (dari DataTables)
        if ($request->ajax()) {
            // Mengambil data produk beserta relasi seller
            $data = Product::with('seller')->select('products.*'); // Gunakan select untuk kejelasan

            return DataTables::of($data)
                ->addColumn('image', function ($product) {
                    $imageUrl = asset('storage/products/' . $product->image); // pastikan path sesuai
                    return '<img src="' . $imageUrl . '" width="100px" alt="Gambar Produk">';
                })
                ->addColumn('seller_name', function ($row) {
                    return $row->seller ? $row->seller->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('products.edit', $row->id);
                    $deleteUrl = route('products.destroy', $row->id);
                    $csrfToken = csrf_field(); // Ambil token CSRF
    
                    // Tombol Edit
                    $editBtn = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></a>';

                    // Tombol Delete dengan Form untuk keamanan (metode DELETE)
                    $deleteBtn = '<form action="' . $deleteUrl . '" method="POST" style="display:inline;">'
                        . $csrfToken
                        . '<input type="hidden" name="_method" value="DELETE">'
                        . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this product?\')"><i class="fas fa-trash"></i></button>'
                        . '</form>';

                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        // Jika bukan request AJAX, tampilkan view biasa
        return view('administrator.products.index');
    }


    public function create()
    {
        $users = User::where('role', 'seller')->get();
        return view('administrator.products.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string|max:255',
            'seller_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $users = User::where('role', 'seller')->get();
        return view('administrator.products.edit', compact('product', 'users'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string|max:255',
            'seller_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && \Storage::disk('public')->exists('products/' . $product->image)) {
                \Storage::disk('public')->delete('products/' . $product->image);
            }

            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy(Product $product)
    {
        // Hapus file gambar jika ada
        if ($product->image && \Storage::disk('public')->exists('products/' . $product->image)) {
            \Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

}