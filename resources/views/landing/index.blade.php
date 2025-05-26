@section('title', 'Selamat Datang')

@extends('layout_landing.app')

@section('content')
    <!-- Banner Slider -->
    <div class="banner-slider">
        <div class="banner-images" id="bannerImages">
            <img src="https://www.claudeusercontent.com/api/placeholder/480/150" alt="Promo Banner 1"
                class="banner-image active" />
            <img src="https://www.claudeusercontent.com/api/placeholder/480/150" alt="Promo Banner 2" class="banner-image" />
            <img src="https://www.claudeusercontent.com/api/placeholder/480/150" alt="Promo Banner 3" class="banner-image" />
        </div>
        <div class="banner-indicators" id="bannerIndicators">
            <div class="indicator active"></div>
            <div class="indicator"></div>
            <div class="indicator"></div>
        </div>
    </div>

    <!-- Category Slider -->
    <div class="category-slider">
        <div class="category-container">
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-cow"></i>
                </div>
                <span class="category-name">Sapi</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-egg"></i>
                </div>
                <span class="category-name">Telur</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-pepper-hot"></i>
                </div>
                <span class="category-name">Sayur</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-regular fa-lemon"></i>
                </div>
                <span class="category-name">Buah</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-drumstick-bite"></i>
                </div>
                <span class="category-name">Ayam</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-mortar-pestle"></i>
                </div>
                <span class="category-name">Rempah</span>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fa-solid fa-fish"></i>
                </div>
                <span class="category-name">Ikan</span>
            </a>
        </div>
    </div>

    <!-- Flash Sale Slider -->
    <div class="slider-container">
        <div class="slider-title">
            <span>⚡ Flash Sale</span>
            <a href="#" class="view-all">Lihat Semua</a>
        </div>
        <div class="slider">
            <div class="slide">
                <a href="checkout.html">
                    <img src="https://www.claudeusercontent.com/api/placeholder/140/140" alt="Flash Sale Item 1"
                        class="slide-image" />
                    <div class="slide-details">
                        <h3 class="slide-title">Sapi Kurban</h3>
                        <span class="slide-price">Rp1.336.224</span>
                    </div>
                </a>
            </div>
            <div class="slide">
                <img src="https://www.claudeusercontent.com/api/placeholder/140/140" alt="Flash Sale Item 2"
                    class="slide-image" />
                <div class="slide-details">
                    <h3 class="slide-title">Ikan Tongkol</h3>
                    <span class="slide-price">Rp214.400</span>
                </div>
            </div>
            <div class="slide">
                <img src="https://www.claudeusercontent.com/api/placeholder/140/140" alt="Flash Sale Item 3"
                    class="slide-image" />
                <div class="slide-details">
                    <h3 class="slide-title">Ikan Nila</h3>
                    <span class="slide-price">Rp54.600</span>
                </div>
            </div>
            <div class="slide">
                <img src="https://www.claudeusercontent.com/api/placeholder/140/140" alt="Flash Sale Item 4"
                    class="slide-image" />
                <div class="slide-details">
                    <h3 class="slide-title">Lado Merah Giliang</h3>
                    <span class="slide-price">Rp7.040</span>
                </div>
            </div>
            <div class="slide">
                <img src="https://www.claudeusercontent.com/api/placeholder/140/140" alt="Flash Sale Item 5"
                    class="slide-image" />
                <div class="slide-details">
                    <h3 class="slide-title">Ikan Kering</h3>
                    <span class="slide-price">Rp29.000</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Products Section Header -->
    <div class="section-header">
        <h2 class="section-title">🔥 Produk Populer</h2>
        <a href="#" class="view-all">Lihat Semua</a>
    </div>

    <!-- Products Grid -->
    <div class="product-grid">
        <div class="product-card">
            <a href="checkout.html">
                <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="Mesin Press Sablon"
                    class="product-image" />
                <div class="product-details">
                    <div class="live-tag"><span class="live-icon">●</span> LIVE</div>
                    <h3 class="product-title">Ikan Kering</h3>
                    <div>
                        <span class="tag tag-red">KOMISI XTRA</span>
                        <span class="tag tag-red">COD</span>
                    </div>
                    <div class="price-info">
                        <span class="product-price">Rp87.040</span>
                        <span class="sales-info">2,6RB Terjual</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="product-card">
            <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="Smart TV" class="product-image" />
            <div class="discount-tag">-85%</div>
            <div class="product-details">
                <div class="live-tag"><span class="live-icon">●</span> LIVE</div>
                <h3 class="product-title">Lado Giliang Merah</h3>
                <div>
                    <span class="tag tag-red">KOMISI XTRA</span>
                    <span class="tag tag-red">COD</span>
                </div>
                <div class="price-info">
                    <span class="product-price">Rp36.224</span>
                    <span class="sales-info"></span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="AC Portable"
                class="product-image" />
            <div class="discount-tag">-62%</div>
            <div class="product-details">
                <div class="tag tag-red">Star+</div>
                <h3 class="product-title">Ikan Nila</h3>
                <div>
                    <span class="tag tag-red">KOMISI XTRA</span>
                    <span class="tag tag-red">COD</span>
                </div>
                <div class="price-info">
                    <span class="product-price">Rp14.400</span>
                    <span class="sales-info">40 Terjual</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="Meja Komputer"
                class="product-image" />
            <div class="discount-tag">-50%</div>
            <div class="product-details">
                <div class="live-tag"><span class="live-icon">●</span> LIVE</div>
                <h3 class="product-title">Lado Merah</h3>
                <div>
                    <span class="tag tag-red">KOMISI XTRA</span>
                    <div class="rating">★ 4.8</div>
                </div>
                <div class="price-info">
                    <span class="product-price">Rp24.600</span>
                    <span class="sales-info">5RB Terjual</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="Bantal" class="product-image" />
            <div class="product-details">
                <h3 class="product-title">Lado Hijau</h3>
                <div class="price-info">
                    <span class="product-price">Rp29.000</span>
                    <span class="sales-info">5,7RB Terjual</span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="https://www.claudeusercontent.com/api/placeholder/400/320" alt="Tirai" class="product-image" />
            <div class="product-details">
                <h3 class="product-title">Ikan Tongkol</h3>
                <div class="price-info">
                    <span class="product-price">Rp79.000</span>
                    <span class="sales-info">17,8RB Terjual</span>
                </div>
            </div>
        </div>
    </div>

    <!-- New Arrivals Slider -->
    <div class="slider-container">
        <div class="slider-title">
            <span>✨ Baru Datang</span>
            <a href="#" class="view-all">Lihat Semua</a>
        </div>
        <div class="slider">
            @foreach ($products as $item)
                <div class="slide">
                    <a
                        href="{{ strtolower(str_replace(' ', '-', $item->seller->name)) }}/{{ strtolower(str_replace(' ', '-', $item->name)) }}">
                        <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->name }}"
                            class="slide-image" />
                        <div class="slide-details">
                            <h3 class="slide-title">{{ $item->name }}</h3>
                            <span class="slide-price">Rp {{ number_format($item->price) }}</span>
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
