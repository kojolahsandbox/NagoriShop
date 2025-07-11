<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') - Nagori Shop</title>

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
