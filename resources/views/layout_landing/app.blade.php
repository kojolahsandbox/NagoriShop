<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title')</title>

    <!-- Meta Description -->
    <meta name="description"
        content="Kodai Nagori adalah platform ecommerce yang menjual produk pertanian, peternakan, dan UMKM dari desa. Belanja produk berkualitas langsung dari petani dan pengusaha desa.">

    <!-- Meta Keywords (optional, used to help with SEO but not a major ranking factor) -->
    <meta name="keywords"
        content="produk pertanian desa, produk peternakan desa, ecommerce UMKM desa, belanja produk desa, hasil pertanian desa, produk UMKM desa, pasar online desa, belanja online pertanian, belanja hasil pertanian">

    <!-- Meta Robots (Directs search engines to index or follow pages) -->
    <meta name="robots" content="index, follow">

    <!-- Canonical Link (to avoid duplicate content issues) -->
    <link rel="canonical" href="https://kodai.nagori.id/">

    <!-- Open Graph Meta Tags for Social Media Sharing -->
    <meta property="og:title" content="Belanja Produk Pertanian, Peternakan & UMKM Desa - Kodai Nagori">
    <meta property="og:description"
        content="Kodai Nagori adalah ecommerce untuk produk pertanian, peternakan, dan UMKM desa. Menjangkau lebih banyak konsumen untuk hasil produk berkualitas langsung dari desa.">
    <meta property="og:image" content="https://kojolahsandbox.github.io/Logo/Kojolah-Sandbox-Logo.png">
    <!-- Link gambar thumbnail -->
    <meta property="og:url" content="https://kodai.nagori.id/">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags for Twitter Sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Belanja Produk Pertanian, Peternakan & UMKM Desa - Kodai Nagori">
    <meta name="twitter:description"
        content="Kodai Nagori adalah ecommerce untuk produk pertanian, peternakan, dan UMKM desa. Temukan berbagai produk berkualitas dari desa langsung ke tangan Anda.">
    <meta name="twitter:image" content="https://kojolahsandbox.github.io/Logo/Kojolah-Sandbox-Logo.png">
    <!-- Link gambar thumbnail -->
    <meta name="twitter:site" content="@kojolah">

    <!-- Favicon -->
    <link rel="icon" href="https://www.kojolah.com/favicon.ico" type="image/x-icon">

    <!-- Structured Data (JSON-LD for Local Business Schema) -->
    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "name": "Kodai Nagori",
          "url": "https://kodai.nagori.id/",
          "logo": "https://kojolahsandbox.github.io/Logo/Kojolah-Sandbox-Logo.png",
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-11-6623-73",
            "contactType": "Customer Service",
            "areaServed": "ID",
            "availableLanguage": "Indonesian"
          },
          "sameAs": [
            "https://www.facebook.com/kojolahsandbox",
            "https://x.com/kojolah",
            "http://instagram.com/kojolah"
          ]
        }
        </script>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-top">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" class="search-input" name="search" id="searchInput"
                        placeholder="Ayam Telur | Payakumbuh | Buah" />
                    <div class="camera-icon">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                <div class="header-icons">
                    {{-- <div class="cart-icon">
                        <i class="fa-solid fa-comment"></i>
                    </div> --}}
                    <div class="message-icon message-badge">
                        <a href="{{ route('cart') }}" style="text-decoration: none; color: inherit;">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="badge">{{ $product_in_cart ? $product_in_cart : 0 }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <div style="height: 60px"></div>

        <div class="menu-bar">
            <a href="{{ url('/') }}" class="menu-item active">
                <div class="menu-icon">
                    <i class="fa-solid fa-house"></i>
                </div>
                <span>Beranda</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <span>Trending</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon">
                    <i class="fa-solid fa-video"></i>
                </div>
                <span>Live & Video</span>
            </a>
            <a href="#" class="menu-item notification-badge">
                <div class="menu-icon">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <span class="notif-badge">46</span>
                <span>Notifikasi</span>
            </a>
            @auth
                <a href="{{ route('profile') }}" class="menu-item">
                    <div class="menu-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span>Saya</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="menu-item">
                    <div class="menu-icon">
                        <i class="fa-solid fa-sign-in-alt"></i>
                    </div>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        const input = document.getElementById('searchInput');

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = input.value.trim();

                if (query !== '') {
                    const sanitizedQuery = encodeURIComponent(query);
                    window.location.href = '/search?keyword=' + sanitizedQuery;
                }
            }
        });
    </script>

    @yield('script')
</body>

</html>
