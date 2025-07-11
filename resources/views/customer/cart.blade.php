<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Nagori Shop</title>

    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <i class="fas fa-arrow-left back-btn" onclick="goBack()"></i>
                <h1 class="header-title">Keranjang Belanja</h1>
            </div>
        </div>

        @if (session('success'))
            <div style="padding:20px; text-align:center; color:#980000;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="padding:20px; text-align:center; color:rgb(141, 10, 10);">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('alert'))
            <div style="padding:20px; text-align:center; color:rgb(141, 10, 10);">
                {{ session('alert') }}
            </div>
        @endif

        <div class="cart-content" id="cartContent">
            <!-- Cart items will be populated here -->
        </div>

        <div class="bottom-section">

            <button class="checkout-btn" id="checkoutBtn">
                Beli Sekarang
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        const cartItems = @json($cartItems);
        let cart = [...cartItems];

        function formatPrice(price) {
            return 'Rp' + price.toLocaleString('id-ID');
        }

        function renderCart() {
            const cartContent = document.getElementById('cartContent');

            if (cart.length === 0) {
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <div class="empty-cart-text">Keranjang belanja Anda kosong</div>
                        <a href="{{ route('home') }}" class="browse-btn">Mulai Belanja</a>
                    </div>
                `;
                return;
            }

            let html = `
                <div class="voucher-section">
                    <div class="voucher-header">
                        <span class="voucher-title">🎫 Voucher Tersedia</span>
                        <a href="#!" class="voucher-link">Lihat Semua</a>
                    </div>
                    <div class="voucher-item">
                        <div class="voucher-icon">🎁</div>
                        <div class="voucher-info">
                            <div class="voucher-name">Belum Ada</div>
                            <div class="voucher-desc">Voucher Tersedia</div>
                        </div>
                        
                    </div>
                </div>
            `;

            cart.forEach(item => {
                const tags = item.tags.map(tag => `<span class="item-tag">${tag}</span>`).join(' ');
                const originalPriceHtml = item.originalPrice ?
                    `<span class="original-price">${formatPrice(item.originalPrice)}</span>
                     <span class="discount-percentage">-${item.discount}%</span>` : '';

                html += `
                    <div class="cart-item">
                        <div class="item-header">
                            <span class="shop-name">${item.shopName}</span>
                        </div>
                        <div class="item-content">
                            <img src="${item.image}" alt="${item.title}" class="item-image">
                            <div class="item-details">
                                <div class="item-title">${item.title}</div>
                                <div class="item-variant">${item.variant}</div>
                                <div class="item-variant">Sebanyak ${item.quantity}</div>
                                ${tags}
                                <div class="item-price">
                                    ${formatPrice(item.originalPrice)}
                                </div>
                            </div>
                        </div>
                        <div class="item-actions">
                            
                            <div class="item-actions-right">
                                <a class="delete-item-btn" href="/cart/delete/${item.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartContent.innerHTML = html;
        }


        function goBack() {
            window.location.href = "/";
        }

        // Initialize the cart
        document.addEventListener('DOMContentLoaded', function() {
            renderCart();
        });
    </script>
</body>

</html>
