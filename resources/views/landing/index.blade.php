@section('title', 'Selamat Datang')

@extends('layout_landing.app')

@section('content')
    <!-- Banner Slider -->
    <div class="banner-slider">
        <div class="banner-images" id="bannerImages">
            @foreach ($slides as $item)
                <img src="{{ $item }}" alt="Promo Banner" class="banner-image {{ $loop->first ? 'active' : '' }}" />
            @endforeach
        </div>
        <div class="banner-indicators" id="bannerIndicators">
            @foreach ($slides as $item)
                <div class="indicator {{ $loop->first ? 'active' : '' }}"></div>
            @endforeach
        </div>
    </div>

    <!-- Category Slider -->
    <div class="category-slider">
        <div class="category-container">
            <a href="{{ url('sapi') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-cow"></i>
                </div>
                <span class="category-name">Sapi</span>
            </a>
            <a href="{{ url('telur') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-egg"></i>
                </div>
                <span class="category-name">Telur</span>
            </a>
            <a href="{{ url('sayur') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-pepper-hot"></i>
                </div>
                <span class="category-name">Sayur</span>
            </a>
            <a href="{{ url('buah') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-regular fa-lemon"></i>
                </div>
                <span class="category-name">Buah</span>
            </a>
            <a href="{{ url('ayam') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-drumstick-bite"></i>
                </div>
                <span class="category-name">Ayam</span>
            </a>
            <a href="{{ url('rempah') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-mortar-pestle"></i>
                </div>
                <span class="category-name">Rempah</span>
            </a>
            <a href="{{ url('ikan') }}" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-fish"></i>
                </div>
                <span class="category-name">Ikan</span>
            </a>
        </div>
    </div>

    @php
        use Illuminate\Support\Str;
    @endphp

    @if ($flash_sale && count($flash_sale))
        <!-- Flash Sale Slider -->
        <div class="slider-container">
            <div class="slider-title">
                <span>⚡ Flash Sale</span>
                <a href="#" class="view-all">Lihat Semua</a>
            </div>
            <div class="slider">
                @foreach ($flash_sale as $item)
                    @php
                        $sellerSlug = Str::slug($item->seller->name);
                        $productSlug = Str::slug($item->name);
                        $productUrl = url("/$sellerSlug/$productSlug");
                        $imagePath = $item->image
                            ? asset('storage/products/' . $item->image)
                            : asset('images/default-product.png');
                    @endphp
                    <div class="slide">
                        <a href="{{ $productUrl }}">
                            <img src="{{ $imagePath }}" alt="Flash Sale Item 1" class="slide-image" />
                            <div class="slide-details">
                                <h3 class="slide-title">{{ $item->name }}</h3>
                                <span class="slide-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    <!-- Popular Products Section Header -->
    <div class="section-header">
        <h2 class="section-title">🔥 Produk Populer</h2>
        <a href="#" class="view-all">Lihat Semua</a>
    </div>

    <!-- Products Grid -->
    <div class="product-grid">
        @foreach ($best_seller as $item)
            @php
                $sellerSlug = Str::slug($item->seller->name);
                $productSlug = Str::slug($item->name);
                $productUrl = url("/$sellerSlug/$productSlug");
                $imagePath = $item->image
                    ? asset('storage/products/' . $item->image)
                    : asset('images/default-product.png');
            @endphp

            <div class="product-card">
                <a href="{{ $productUrl }}">
                    <img src="{{ $imagePath }}" alt="{{ $item->name }}" class="product-image" loading="lazy" />
                    <div class="product-details">
                        {{-- Optional LIVE Tag --}}
                        {{-- <div class="live-tag"><span class="live-icon">●</span> LIVE</div> --}}

                        <h3 class="product-title">{{ $item->name }}</h3>

                        {{-- Optional Tags --}}
                        {{-- 
                        <div class="product-tags">
                            <span class="tag tag-red">KOMISI XTRA</span>
                            <span class="tag tag-red">COD</span>
                        </div>
                        --}}

                        <div class="price-info">
                            <span class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>

                            {{-- Optional Sales Info --}}
                            {{-- <span class="sales-info">2,6RB Terjual</span> --}}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- New Arrivals Slider -->
    <div class="slider-container">
        <div class="slider-title">
            <span>✨ Baru Datang</span>
            <a href="#" class="view-all">Lihat Semua</a>
        </div>
        <div class="slider">
            @foreach ($products as $item)
                @php
                    $sellerSlug = Str::slug($item->seller->name);
                    $productSlug = Str::slug($item->name);
                    $productUrl = url("/$sellerSlug/$productSlug");
                    $imagePath = $item->image
                        ? asset('storage/products/' . $item->image)
                        : asset('images/default-product.png');
                @endphp
                <div class="slide">
                    <a href="{{ $productUrl }}">
                        <img src="{{ $imagePath }}" alt="{{ $item->name }}" class="slide-image" />
                        <div class="slide-details">
                            <h3 class="slide-title">{{ $item->name }}</h3>
                            <span class="slide-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')

    <script>
        // Banner Slider Functionality
        document.addEventListener("DOMContentLoaded", function() {
            const bannerImages = document.querySelectorAll(".banner-image");
            const indicators = document.querySelectorAll(".indicator");
            let currentSlide = 0;

            // Function to change slide
            function changeSlide() {
                // Remove active class from all images and indicators
                bannerImages.forEach((img) => img.classList.remove("active"));
                indicators.forEach((ind) => ind.classList.remove("active"));

                // Add active class to current slide and indicator
                bannerImages[currentSlide].classList.add("active");
                indicators[currentSlide].classList.add("active");

                // Move to next slide or back to first
                currentSlide = (currentSlide + 1) % bannerImages.length;
            }

            // Set interval for auto sliding
            const slideInterval = setInterval(changeSlide, 3000);

            // Add click functionality to indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener("click", () => {
                    // Clear the automatic interval
                    clearInterval(slideInterval);

                    // Set current slide to clicked indicator
                    currentSlide = index;

                    // Change to selected slide
                    changeSlide();

                    // Restart automatic sliding
                    setInterval(changeSlide, 3000);
                });
            });
        });
    </script>

@endsection
