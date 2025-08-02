<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Nagori Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}" style="text-decoration: none;">
                <div class="header-left">
                    <i class="fas fa-arrow-left back-btn"></i>
                    <h1 class="header-title">Keranjang Belanja</h1>
                </div>
            </a>
        </div>

        <div id="shopSwitchNotice" class="shop-switch-notice" style="display: none;">
            <i class="fas fa-info-circle"></i> Anda hanya dapat memilih produk dari satu toko per pesanan
        </div>

        <div class="cart-content" id="cartContent">
            <!-- Cart items will be populated here -->
        </div>

        <div class="bottom-section">
            <div class="checkout-summary">
                <span class="selected-count" id="selectedCount">0 produk dipilih</span>
                <span class="total-price" id="totalPrice">Rp0</span>
            </div>
            <button class="checkout-btn" id="checkoutBtn" disabled>
                Beli Sekarang
            </button>
        </div>
    </div>

    <script>
        // Cart data from controller
        const cartItems = @json($cartItems);

        let cart = [...cartItems];
        let selectedShop = null;
        let selectedItems = new Set();

        function formatPrice(price) {
            return 'Rp' + Number(price).toLocaleString('id-ID');
        }

        function groupItemsByShop() {
            const shops = {};
            cart.forEach(item => {
                if (!shops[item.shopName]) {
                    shops[item.shopName] = [];
                }
                shops[item.shopName].push(item);
            });
            return shops;
        }

        function renderCart() {
            const cartContent = document.getElementById('cartContent');

            if (cart.length === 0) {
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <div class="empty-cart-text">Keranjang belanja Anda kosong</div>
                        <a href="#!" class="browse-btn">Mulai Belanja</a>
                    </div>
                `;
                return;
            }

            const shopGroups = groupItemsByShop();
            let html = '';

            Object.keys(shopGroups).forEach(shopName => {
                const items = shopGroups[shopName];
                const isShopSelected = selectedShop === shopName;

                html += `
                    <div class="shop-section">
                        <div class="shop-header">
                            <span class="shop-name">${shopName}</span>
                            <div class="shop-selector">
                                <span class="shop-label">Pilih Toko</span>
                                <div class="shop-checkbox ${isShopSelected ? 'selected' : ''}" 
                                     onclick="selectShop('${shopName}')"></div>
                            </div>
                        </div>
                `;

                items.forEach(item => {
                    const isItemSelected = selectedItems.has(String(item.id));
                    const itemClass = isShopSelected ? 'selected' : '';
                    const tags = item.tags && item.tags.length > 0 ?
                        item.tags.map(tag => `<span class="item-tag">${tag}</span>`).join(' ') :
                        '';

                    html += `
                        <div class="cart-item ${itemClass}">
                            <div class="item-content">
                                <img src="${item.image}" alt="${item.title}" class="item-image" onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                                <div class="item-details">
                                    <div class="item-title">${item.title}</div>
                                    <div class="item-variant">${item.variant}</div>
                                    <div class="item-variant">Sebanyak ${item.quantity}</div>
                                    <div class="item-tags">${tags}</div>
                                    <div class="item-price">
                                        ${formatPrice(item.originalPrice)}
                                    </div>
                                </div>
                            </div>
                            <div class="item-actions">
                                <div class="item-checkbox ${isItemSelected ? 'selected' : ''}" 
                                     onclick="toggleItemSelection('${item.id}', '${shopName}')"
                                     ${!isShopSelected ? 'style="pointer-events: none; opacity: 0.3;"' : ''}></div>
                                     <a href="/cart/delete/${item.id}" style="color:inherit;">
                                        <div class="delete-item-btn">
                                        <i class="fas fa-trash"></i>
                                        </div>
                                    </a>
                            </div>
                        </div>
                    `;
                });

                html += `</div>`;
            });

            cartContent.innerHTML = html;
            updateCheckoutButton();
        }

        function selectShop(shopName) {
            if (selectedShop === shopName) {
                // Deselect shop
                selectedShop = null;
                selectedItems.clear();
                document.getElementById('shopSwitchNotice').style.display = 'none';
            } else {
                // Select new shop
                if (selectedShop !== null && selectedShop !== shopName) {
                    // Show notice when switching shops
                    document.getElementById('shopSwitchNotice').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('shopSwitchNotice').style.display = 'none';
                    }, 3000);
                }
                selectedShop = shopName;
                selectedItems.clear();

                // Auto-select all items from the selected shop
                cart.forEach(item => {
                    if (item.shopName === shopName) {
                        selectedItems.add(String(item.id));
                    }
                });
            }
            renderCart();
        }

        function toggleItemSelection(itemId, shopName) {
            if (selectedShop !== shopName) {
                return; // Can't select items from unselected shop
            }

            // Convert itemId to string for consistent comparison
            const itemIdStr = String(itemId);

            if (selectedItems.has(itemIdStr)) {
                selectedItems.delete(itemIdStr);
            } else {
                selectedItems.add(itemIdStr);
            }

            // If no items selected from this shop, deselect the shop
            const shopItems = cart.filter(item => item.shopName === shopName);
            const selectedShopItems = shopItems.filter(item => selectedItems.has(String(item.id)));

            if (selectedShopItems.length === 0) {
                selectedShop = null;
            }

            renderCart();
        }


        function updateCheckoutButton() {
            const checkoutBtn = document.getElementById('checkoutBtn');
            const selectedCount = document.getElementById('selectedCount');
            const totalPrice = document.getElementById('totalPrice');

            const selectedItemsArray = cart.filter(item => selectedItems.has(String(item.id)));
            const total = selectedItemsArray.reduce((sum, item) => {
                // Calculate total based on original price (which already includes quantity)
                return sum + item.originalPrice;
            }, 0);

            selectedCount.textContent = `${selectedItemsArray.length} produk dipilih`;
            totalPrice.textContent = formatPrice(total);

            checkoutBtn.disabled = selectedItemsArray.length === 0;

            if (selectedItemsArray.length > 0) {
                checkoutBtn.textContent = `Checkout (${selectedItemsArray.length} item)`;
            } else {
                checkoutBtn.textContent = 'Beli Sekarang';
            }
        }

        function checkout() {
            if (selectedItems.size === 0) {
                alert('Silakan pilih minimal 1 produk untuk checkout');
                return;
            }

            const selectedItemsArray = cart.filter(item => selectedItems.has(String(item.id)));
            const total = selectedItemsArray.reduce((sum, item) => sum + item.originalPrice, 0);

            const checkoutData = {
                shop: selectedShop,
                items: selectedItemsArray.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    variant_id: item.variant_id,
                    product_id: item.product_id,
                })),
                total: total
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('checkout.cart') }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);

            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'checkout_data';
            dataInput.value = JSON.stringify(checkoutData);
            form.appendChild(dataInput);

            document.body.appendChild(form);
            form.submit();
        }


        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Add CSRF token meta tag if not exists
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }

            renderCart();
            document.getElementById('checkoutBtn').addEventListener('click', checkout);
        });
    </script>
</body>

</html>
