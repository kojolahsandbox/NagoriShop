@extends('administrator.layout.app')

@section('title', 'Edit Produk')

@section('content')
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label for="seller_id">Pilih Seller</label>
            <select name="seller_id" class="form-control" required>
                <option value="">Pilih Seller</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if ($product->seller_id == $user->id) selected @endif>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk</label>
            <input type="file" class="form-control" id="image" name="image">
            <p>Gambar sebelumnya: <img src="{{ asset('storage/products/' . $product->image) }}" width="100px"
                    alt="Product Image" class="mt-3">
            </p>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ $product->category }}"
                required>
        </div>

        <div class="form-group">
            <label for="stock">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
@endsection
