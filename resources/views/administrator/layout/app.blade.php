<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Judul halaman akan dinamis --}}
    <title>Kodai Nagori | @yield('title')</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="https://kojolahsandbox.github.io/Logo/Nagari/custom-adminlte.css">

    {{-- Untuk CSS tambahan per halaman --}}
    @yield('head')
</head>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        @include('administrator.layout.partials.navbar')
        @include('administrator.layout.partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- Ganti route ke home admin Anda --}}
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    {{-- Di sinilah konten utama dari setiap halaman akan dimuat --}}
                    @yield('content')
                </div>
            </section>
        </div>
        @include('administrator.layout.partials.footer')

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>

    {{-- Untuk script tambahan per halaman --}}
    @yield('script')
</body>

</html>
