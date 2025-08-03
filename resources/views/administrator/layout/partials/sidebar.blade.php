<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#!" class="brand-link">
        <img src="https://kojolahsandbox.github.io/Logo/Kojolah-Sandbox-Logo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kodai Admin</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: none;">
            <div class="image">
                <img src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?d=mm"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">Menu</li>
                <li class="nav-item">
                    <a href="{{ route('administrator') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pelanggan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Analitik
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
