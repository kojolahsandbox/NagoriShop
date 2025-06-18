@section('product', $product->name)

@extends('layout_landing.detail')

@section('content')


    <!-- Product Images -->
    <div class="product-images">
        <div class="main-image-container">
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="main-image"
                id="mainImage" />
            {{-- <div class="discount-badge">-42%</div> --}}
            <button class="favorite-btn" id="favoriteBtn">
                <i class="fa-regular fa-heart"></i>
            </button>
            <div class="image-indicators">
                <div class="indicator active"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
            </div>
        </div>
    </div>

    <!-- Product Info -->
    <div class="product-info">
        <h1 class="product-title">{{ $product->name }}</h1>

        {{-- <div class="product-rating">
            <div class="rating-stars">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <span style="margin-left: 5px; color: #333">4.8</span>
            </div>
            <div class="rating-text">(2,6rb ulasan) • 5,2rb terjual</div>
        </div> --}}

        <div class="product-price-section">
            <div class="current-price">Rp {{ number_format($product->price) }}</div>
            {{-- <div class="price-details">
                <span class="original-price">Rp150.000</span>
                <span class="discount-percentage">42% OFF</span>
            </div> --}}
        </div>

        <div class="product-tags">
            <span class="tag tag-live">
                <i class="fa-solid fa-circle" style="font-size: 8px; margin-right: 5px"></i>
                {{ $product->category }}
            </span>
            {{-- <span class="tag tag-cod">COD</span>
            <span class="tag tag-komisixtra">KOMISI XTRA</span> --}}
        </div>
    </div>

    <!-- Variants Section -->
    <div class="variants-section">
        <div class="section-title">Pilih Varian</div>
        <div class="variant-options">
            @php $no = 1 @endphp
            @foreach ($product->variants as $item)
                @if ($no == 1)
                    <div class="variant-option selected">{{ $item->variant }}</div>
                @endif
                <div class="variant-option">{{ $item->variant }}</div>
                @php
                    $no++;
                @endphp
            @endforeach
        </div>
    </div>

    <!-- Quantity Section -->
    <div class="quantity-section">
        <div class="section-title">Jumlah</div>
        <div class="quantity-controls">
            <button class="quantity-btn" id="decreaseBtn">-</button>
            <input type="number" class="quantity-input" value="1" min="1" max="{{ $product->stock }}"
                id="quantityInput" />
            <button class="quantity-btn" id="increaseBtn">+</button>
            <span class="stock-info">Stok: {{ $product->stock }}</span>
        </div>
    </div>

    <!-- Description Section -->
    <div class="description-section">
        <div class="section-title">Deskripsi Produk</div>
        @php
            $words = explode(' ', $product->description);
            $isLong = count($words) > 30;
            $shortDescription = implode(' ', array_slice($words, 0, 30));
            $fullDescription = $isLong ? implode(' ', array_slice($words, 30)) : '';
        @endphp

        <div class="description-text" id="descriptionText">
            {!! nl2br(e($shortDescription)) !!}

            @if ($isLong)
                <div class="hidden" id="fullDescription">
                    {!! nl2br(e($fullDescription)) !!}
                </div>
            @endif
        </div>

        <div class="show-more" id="showMoreBtn">Selengkapnya</div>
    </div>

    <!-- Reviews Section -->
    {{-- <div class="reviews-section">
        <div class="reviews-header">
            <div class="section-title">Ulasan Pembeli</div>
            <a href="#" class="view-all-reviews">Lihat Semua</a>
        </div>

        <div class="review-item">
            <div class="review-header">
                <div class="reviewer-name">Sari Dewi</div>
                <div class="review-date">2 hari lalu</div>
            </div>
            <div class="review-rating">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="review-text">
                Kualitas ikan keringnya bagus banget! Teksturnya pas, tidak terlalu
                keras dan rasanya gurih. Kemasan juga rapi dan higienis.
                Recommended!
            </div>
        </div>

        <div class="review-item">
            <div class="review-header">
                <div class="reviewer-name">Budi Santoso</div>
                <div class="review-date">1 minggu lalu</div>
            </div>
            <div class="review-rating">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="review-text">
                Sudah beberapa kali order di sini, selalu puas dengan kualitasnya.
                Pengiriman cepat dan packaging aman.
            </div>
        </div>
    </div> --}}

    <!-- Seller Info -->
    <div class="seller-section">
        <div class="section-title">Informasi Toko</div>
        <div class="seller-info">
            @php
                $name = $product->seller->name;
                $initials = collect(explode(' ', $name))
                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                    ->implode('');
            @endphp
            <div class="seller-avatar">{{ $initials }}</div>
            <div class="seller-details">
                <div class="seller-name">{{ $product->seller->name }}</div>
                {{-- <div class="seller-stats">
                    <span>⭐ 4.9 (12,5rb ulasan)</span>
                    <span>📦 15,2rb produk</span>
                </div> --}}
            </div>
            <button class="chat-seller-btn">
                <i class="fa-solid fa-comment"></i> Chat
            </button>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-section">
        <div class="section-title">Produk Lainnya</div>
        <div class="related-products">
            @foreach ($others as $item)
                @if ($item->id != $product->id)
                    <div class="related-product">
                        <a style="text-decoration: none; color: inherit"
                            href="{{ url(strtolower(str_replace(' ', '-', $item->seller->name)) . '/' . strtolower(str_replace(' ', '-', $item->name))) }}">
                            <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->name }}"
                                class="related-image" />
                            <div class="related-name">{{ $item->name }}</div>
                            <div class="related-price">Rp {{ number_format($item->price) }}</div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <button class="action-btn add-to-cart-btn">
            <i class="fa-solid fa-cart-plus"></i> Keranjang
        </button>
        <button class="action-btn buy-now-btn">Beli Sekarang</button>
    </div>

@endsection

@section('script')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Favorite button functionality
            const favoriteBtn = document.getElementById("favoriteBtn");
            favoriteBtn.addEventListener("click", function() {
                const icon = this.querySelector("i");
                if (icon.classList.contains("fa-regular")) {
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                    this.classList.add("active");
                } else {
                    icon.classList.remove("fa-solid");
                    icon.classList.add("fa-regular");
                    this.classList.remove("active");
                }
            });

            // Variant selection
            const variantOptions = document.querySelectorAll(".variant-option");
            variantOptions.forEach((option) => {
                option.addEventListener("click", function() {
                    variantOptions.forEach((opt) => opt.classList.remove("selected"));
                    this.classList.add("selected");
                });
            });

            // Quantity controls
            const quantityInput = document.getElementById("quantityInput");
            const decreaseBtn = document.getElementById("decreaseBtn");
            const increaseBtn = document.getElementById("increaseBtn");

            decreaseBtn.addEventListener("click", function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener("click", function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < 99) {
                    quantityInput.value = currentValue + 1;
                }
            });

            // Description show more/less
            const showMoreBtn = document.getElementById("showMoreBtn");
            const fullDescription = document.getElementById("fullDescription");

            showMoreBtn.addEventListener("click", function() {
                if (fullDescription.classList.contains("hidden")) {
                    fullDescription.classList.remove("hidden");
                    this.textContent = "Lebih Sedikit";
                } else {
                    fullDescription.classList.add("hidden");
                    this.textContent = "Selengkapnya";
                }
            });

            // Image indicator simulation (you can add image slider functionality here)
            const indicators = document.querySelectorAll(".indicator");
            let currentImageIndex = 0;

            // Simulate image change every 5 seconds
            setInterval(() => {
                indicators[currentImageIndex].classList.remove("active");
                currentImageIndex = (currentImageIndex + 1) % indicators.length;
                indicators[currentImageIndex].classList.add("active");
            }, 5000);
        });
    </script>

@endsection
