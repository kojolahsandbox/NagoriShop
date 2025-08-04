@extends('administrator.layout.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Produk Pesanan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotalProduk = 0; @endphp
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                            alt="{{ $item->product_name }}" width="50" class="mr-2">
                                        {{ $item->product_name }}
                                    </td>
                                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @php $subtotalProduk += $item->unit_price * $item->quantity; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pelanggan & Pengiriman</h3>
                </div>
                <div class="card-body">
                    <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Telepon:</strong> {{ $order->user->phone }}</p>
                    <p><strong>Alamat Pengiriman:</strong><br>
                        {{ $order->address->address_text }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Proses Pesanan</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="shipping_fee">Alamat Pengiriman</label>
                            <p>{{ $order->address->address_text }}</p>
                        </div>
                        <div class="form-group">
                            <label for="shipping_fee">Ongkos Kirim</label>
                            <input type="number" name="shipping_fee" id="shipping_fee" class="form-control"
                                value="{{ $order->shipping_fee }}" required>
                            <small class="form-text text-muted">Masukkan ongkir untuk mengkonfirmasi pesanan.</small>
                        </div>

                        <div class="form-group">
                            <label for="status">Status Pesanan</label>
                            <select name="status" id="status" class="form-control">
                                <option value="draft" @if ($order->status == 'draft') selected @endif>Menunggu Konfirmasi
                                </option>
                                <option value="waiting_payment" @if ($order->status == 'waiting_payment') selected @endif>Menunggu
                                    Pembayaran</option>
                                <option value="paid" @if ($order->status == 'paid') selected @endif>Dibayar (Siap
                                    Dikemas)</option>
                                <option value="shipped" @if ($order->status == 'shipped') selected @endif>Dikirim</option>
                                <option value="completed" @if ($order->status == 'completed') selected @endif>Selesai</option>
                                <option value="cancelled" @if ($order->status == 'cancelled') selected @endif>Dibatalkan
                                </option>
                            </select>
                        </div>

                        <hr>

                        <h5>Ringkasan Pembayaran</h5>
                        <p>Subtotal Produk: Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</p>
                        <p>Ongkos Kirim: Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</p>
                        <p>Biaya Layanan (1%): Rp
                            {{ number_format(($subtotalProduk + $order->shipping_fee) * 0.01, 0, ',', '.') }}</p>
                        <p><strong>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>

                        <button type="submit" class="btn btn-primary btn-block">Update Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
