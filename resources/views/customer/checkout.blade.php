<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }} - Nagori Shop</title>
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="javascript:history.back()">
                <div class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
            </a>
            <h1 class="page-title">Checkout</h1>
        </div>

        <!-- Address Section -->
        <div class="section">
            <div class="section-title">
                <span>Alamat Pengiriman</span>
                <a href="{{ route('profile') }}" class="edit-link">Ubah</a>
            </div>
            <div class="address-details">
                <div class="address-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="address-info">
                    <div class="address-name">
                        {{ strtoupper(auth()->user()->name) }} <span class="default-tag">Utama</span>
                    </div>
                    <div class="address-phone">{{ auth()->user()->phone }}</div>
                    <div class="address-text">
                        {{ $address->address_text }}
                    </div>
                </div>
            </div>
            @if ($order->shipping_status == 'confirmed' && $order->status == 'waiting_payment')
                <div class="address-details" style="justify-content: center;">
                    <div class="address-name">
                        <a style="text-decoration: none; color:inherit;"
                            href="{{ route('cancel.order', ['id' => $order->id]) }}" class="">Batalkan
                            Pesanan</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Products Section -->
        <div class="section">
            <div class="section-title">
                <span>Produk yang Dibeli</span>
            </div>
            <div class="product-list">
                @php $total = 0; @endphp
                @foreach ($orderItems as $item)
                    <div class="product-item">
                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                            alt="{{ $item->product_name }}" class="product-image" />
                        <div class="product-info">
                            <div class="product-name">{{ $item->product_name }}</div>
                            <div class="product-variant">{{ $item->variant }}</div>
                            <div class="product-price-qty">
                                <div class="product-price">Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </div>
                                <div class="product-qty">x{{ $item->quantity }}</div>
                            </div>
                        </div>
                    </div>
                    @php $total += $item->unit_price * $item->quantity; @endphp
                @endforeach
            </div>
        </div>

        <!-- Shipping Section -->
        {{-- <div class="section">
            <div class="section-title">
                <span>Pengiriman</span>
                <a href="#!" class="edit-link">Ubah</a>
            </div>
            <div class="shipping-option">
                <div class="radio-container">
                    <div class="radio-custom radio-selected">
                        <div class="radio-dot"></div>
                    </div>
                    <div class="shipping-details">
                        <div class="shipping-name">Nagori Express</div>
                        <div class="shipping-info">Estimasi tiba 2-3 hari</div>
                    </div>
                    <div class="shipping-price">Rp18.000</div>
                </div>
            </div>
            <div class="shipping-option">
                <div class="radio-container">
                    <div class="radio-custom">
                        <div class="radio-dot"></div>
                    </div>
                    <div class="shipping-details">
                        <div class="shipping-name">Hemat</div>
                        <div class="shipping-info">Estimasi tiba 4-5 hari</div>
                    </div>
                    <div class="shipping-price">Rp10.000</div>
                </div>
            </div>
        </div> --}}

        <!-- Payment Method Section -->
        <div class="section">
            <div class="section-title">
                <span>Metode Pembayaran</span>
                <a href="#!" class="edit-link">Ubah</a>
            </div>
            <div class="payment-method">
                <div class="payment-icon">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <div class="payment-name">QRIS</div>
                <div class="payment-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
            @if ($qris && $qris->qris_invoicestatus == 'unpaid')
                @if (session('alert'))
                    <div class="payment-method" style="color:rgb(141, 10, 10);">
                        {{ session('alert') }}
                    </div>
                @endif

                <div class="payment-method">
                    <span>Scan QR Berikut:</span>
                </div>
                <div class="payment-method">
                    <span>Gunakan Mobile Banking atau Dompet Digital yang mendukung pembayaran menggunakan
                        QRIS.<br><br>Pembayaran Berlaku sampai<br><b style="color: #980000;">
                            {{ \Carbon\Carbon::parse($qris->qris_request_date)->addMinutes(30)->format('d F Y | H:i') }}
                            WIB</b></span>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qris->qris_content }}"
                        alt="">
                </div>
                <div class="payment-method">
                    <a style="text-decoration: none;" href="{{ route('check.payment', ['id' => $qris->id]) }}"
                        class="checkout-button" id="btn-cek-status">Cek Status
                        Bayar</a>
                </div>
            @endif
        </div>

        <!-- Promo Code Section -->
        <div class="section">
            <div class="section-title">
                <span>Kode Promo</span>
            </div>
            <div class="promo-input">
                <input type="text" class="promo-field" placeholder="Masukkan kode promo" />
                <button class="promo-button">Pakai</button>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="section">
            <div class="section-title">
                <span>Catatan</span>
            </div>
            <textarea class="notes-input" placeholder="Tambahkan catatan untuk penjual (opsional)" rows="3"></textarea>
        </div>

        <!-- Order Summary Section -->
        <div class="section">
            <div class="section-title">
                <span>Ringkasan Pesanan</span>
            </div>
            <div class="summary-item">
                <div class="summary-label">Subtotal Produk</div>
                <div class="summary-value">{{ number_format($total, 0, ',', '.') }}
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Biaya Pengiriman</div>
                <div class="summary-value">{{ number_format($order->shipping_fee, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Diskon Pengiriman</div>
                <div class="summary-value">-0</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Biaya Layanan 1%</div>
                @if ($order->shipping_fee == 0 || $order->shipping_status == 'pending')
                    <div class="summary-value">Menunggu Konfirmasi Admin</div>
                @else
                    <div class="summary-value">{{ $fee = ($total + $order->shipping_fee) * 0.01 }}</div>
                @endif
            </div>
            <div class="total-row">
                <div class="total-label">Total Pembayaran</div>
                @if ($order->shipping_fee == 0 || $order->shipping_status == 'pending')
                    <div class="total-value">Menunggu Konfirmasi Admin</div>
                @else
                    <div class="total-value">Rp {{ number_format($total + $order->shipping_fee + $fee, 0, ',', '.') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Checkout Button -->
    <div class="checkout-bar">
        <div class="checkout-total">
            @if ($order->shipping_fee == 0 || $order->shipping_status == 'pending')
                Total: <span class="checkout-price">Menunggu Konfirmasi Admin</span>
            @else
                Total: <span class="checkout-price">Rp
                    {{ number_format($total + $order->shipping_fee + $fee, 0, ',', '.') }}</span>
            @endif
        </div>
        @if ($order->shipping_status == 'confirmed' && $order->status == 'draft')
            <a style="text-decoration: none;" href="{{ route('generate.qris', ['id' => $order->id]) }}"
                class="checkout-button" id="btn-bayar">Bayar Sekarang</a>
        @endif
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Radio button functionality
        document.addEventListener("DOMContentLoaded", function() {
            const radioContainers = document.querySelectorAll(".radio-container");

            radioContainers.forEach((container) => {
                container.addEventListener("click", function() {
                    // Remove selected class from all radio buttons
                    document.querySelectorAll(".radio-custom").forEach((radio) => {
                        radio.classList.remove("radio-selected");
                    });

                    // Add selected class to clicked radio button
                    const radio = this.querySelector(".radio-custom");
                    radio.classList.add("radio-selected");
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handler untuk "Bayar Sekarang"
            const bayarBtn = document.getElementById("btn-bayar");
            if (bayarBtn) {
                bayarBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    bayarBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
                    bayarBtn.classList.add('disabled');
                    setTimeout(() => {
                        window.location.href = bayarBtn.href;
                    }, 500); // jeda untuk tampilkan animasi
                });
            }

            // Handler untuk "Cek Status Bayar"
            const cekBtn = document.getElementById("btn-cek-status");
            if (cekBtn) {
                cekBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    cekBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mengecek...';
                    cekBtn.classList.add('disabled');
                    setTimeout(() => {
                        window.location.href = cekBtn.href;
                    }, 500);
                });
            }
        });
    </script>

</body>

</html>
