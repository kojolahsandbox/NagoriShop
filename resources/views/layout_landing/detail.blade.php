<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('product') - Nagori Shop</title>

    <link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="javascript:history.back()">
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
