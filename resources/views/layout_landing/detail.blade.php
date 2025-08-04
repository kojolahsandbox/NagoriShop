<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('product') - Kodai Nagori</title>


    <!-- Meta Description -->
    <meta name="description" content="{{ $product->name . ' - ' . $product->description }}">

    <!-- Meta Keywords (optional, used to help with SEO but not a major ranking factor) -->
    <meta name="keywords"
        content="{{ $product->name }}, produk pertanian desa, produk peternakan desa, ecommerce UMKM desa, belanja produk desa, hasil pertanian desa, produk UMKM desa, pasar online desa, belanja online pertanian, belanja hasil pertanian">

    <!-- Meta Robots (Directs search engines to index or follow pages) -->
    <meta name="robots" content="index, follow">

    <!-- Canonical Link (to avoid duplicate content issues) -->
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Open Graph Meta Tags for Social Media Sharing -->
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $product->name . ' - ' . $product->description }}">
    <meta property="og:image" content="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
    <!-- Link gambar thumbnail -->
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags for Twitter Sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ $product->name . ' - ' . $product->description }}">
    <meta name="twitter:image" content="{{ asset('storage/products/' . $product->image) }}"
        alt="{{ $product->name }}">
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

    <link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="{{ route('home') }}">
                    <div class="back-button">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </a>
            </div>
            <div class="header-right">
                <div class="header-icon">
                    <i class="fa-solid fa-share"></i>
                </div>
                <div class="header-icon">
                    <a href="{{ route('cart') }}" style="text-decoration: none; color: inherit;">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-badge">{{ $product_in_cart ? $product_in_cart : 0 }}</span>
                    </a>
                </div>
                <div class="header-icon">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    @yield('script')
</body>

</html>
