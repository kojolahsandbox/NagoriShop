<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title }} - Nagori Shop</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="container">
        <!-- Login Page -->
        <div class="page active" id="login-page">
            <div class="auth-header">
                <a href="javascript:history.back()">
                    <div class="back-button">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </a>
                <h1 class="header-title">Masuk</h1>
            </div>

            <div class="form-container">
                <div class="form-section">
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required autofocus class="input-field"
                                placeholder="Contoh: nama@email.com" />
                        </div>

                        <div class="input-group">
                            <label for="password">Kata Sandi</label>
                            <div class="password-field-container">
                                <input type="password" id="password" name="password" class="input-field"
                                    placeholder="Masukkan kata sandi" />
                                <div class="toggle-password" onclick="togglePassword('password')">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div style="color:rgb(141, 10, 10);">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if (session('alert'))
                            <div style="color:rgb(141, 10, 10);">
                                {{ session('alert') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div style="color:#ff4b2b">
                                {{ session('success') }}
                            </div>
                        @endif


                        <div class="forgot-password">
                            <a href="#" onclick="showPage('forgot-password-page')">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" class="submit-button">Masuk</button>
                    </form>

                    <div class="or-divider">
                        <div class="divider-line"></div>
                        <div class="divider-text">atau masuk dengan</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="social-login">
                        <button class="social-button">
                            <span class="social-icon"><i class="fa-brands fa-google"></i></span>
                            Google
                        </button>
                        <button class="social-button">
                            <span class="social-icon"><i class="fa-brands fa-facebook-f"></i></span>
                            Facebook
                        </button>
                    </div>

                    <div class="register-prompt">
                        Belum punya akun?
                        <a href="#" onclick="showPage('register-page')">Daftar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Page -->
        <div class="page" id="register-page">
            <div class="auth-header">
                <div class="back-button" onclick="showPage('login-page')">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <h1 class="header-title">Daftar</h1>
            </div>

            <div class="form-container">
                <div class="form-section">
                    <div class="form-tabs">
                        <div class="tab active" id="email-tab" onclick="switchTab('email')">
                            Email
                        </div>
                        {{-- <div class="tab" id="phone-tab" onclick="switchTab('phone')">
                            Nomor Telepon
                        </div> --}}
                    </div>

                    <form id="register-form-email" method="POST" class="active" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group">
                            <label for="reg-name">Nama Lengkap</label>
                            <input type="text" name="name" id="reg-name" required class="input-field"
                                placeholder="Masukkan nama lengkap" />
                        </div>

                        <div class="input-group">
                            <label for="reg-email">Email</label>
                            <input type="email" name="email" id="reg-email" required class="input-field"
                                placeholder="Contoh: nama@email.com" />
                        </div>

                        <div class="input-group">
                            <label for="reg-password">Kata Sandi</label>
                            <div class="password-field-container">
                                <input type="password" name="password" required id="reg-password" class="input-field"
                                    placeholder="Minimal 8 karakter" />
                                <div class="toggle-password" onclick="togglePassword('reg-password')">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                            </div>
                        </div>

                        <div class="terms-checkbox">
                            <input type="checkbox" required id="terms" />
                            <label for="terms" class="terms-text">
                                Dengan mendaftar, saya menyetujui
                                <a href="#">Syarat & Ketentuan</a> serta
                                <a href="#">Kebijakan Privasi</a>
                            </label>
                        </div>

                        <button type="submit" class="submit-button">Daftar</button>
                    </form>

                    <form id="register-form-phone" style="display: none">
                        <div class="input-group">
                            <label for="reg-phone-name">Nama Lengkap</label>
                            <input type="text" id="reg-phone-name" class="input-field"
                                placeholder="Masukkan nama lengkap" />
                        </div>

                        <div class="input-group">
                            <label for="reg-phone">Nomor Telepon</label>
                            <input type="tel" id="reg-phone" class="input-field"
                                placeholder="Contoh: 08123456789" />
                        </div>

                        <div class="input-group">
                            <label for="reg-phone-password">Kata Sandi</label>
                            <div class="password-field-container">
                                <input type="password" id="reg-phone-password" class="input-field"
                                    placeholder="Minimal 8 karakter" />
                                <div class="toggle-password" onclick="togglePassword('reg-phone-password')">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div style="color:rgb(141, 10, 10);">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if (session('alert'))
                            <div style="color:rgb(141, 10, 10);">
                                {{ session('alert') }}
                            </div>
                        @endif

                        <div class="terms-checkbox">
                            <input type="checkbox" id="phone-terms" />
                            <label for="phone-terms" class="terms-text">
                                Dengan mendaftar, saya menyetujui
                                <a href="#">Syarat & Ketentuan</a> serta
                                <a href="#">Kebijakan Privasi</a>
                            </label>
                        </div>

                        <button type="button" class="submit-button">Daftar</button>
                    </form>

                    <div class="login-prompt">
                        Sudah punya akun?
                        <a href="#" onclick="showPage('login-page')">Masuk</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forgot Password Page -->
        <div class="page" id="forgot-password-page">
            <div class="auth-header">
                <div class="back-button" onclick="showPage('login-page')">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <h1 class="header-title">Reset Kata Sandi</h1>
            </div>

            <div class="form-container">
                <div class="form-section">
                    <p style="margin-bottom: 20px; color: #666">
                        Masukkan email atau nomor telepon yang terdaftar untuk menerima
                        tautan reset kata sandi.
                    </p>

                    <form id="forgot-password-form">
                        <div class="input-group">
                            <label for="forgot-email">Email / Nomor Telepon</label>
                            <input type="text" id="forgot-email" class="input-field"
                                placeholder="Contoh: nama@email.com" />
                        </div>

                        <button type="button" class="submit-button" onclick="showPage('reset-success-page')">
                            Kirim Tautan Reset
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reset Success Page -->
        <div class="page" id="reset-success-page">
            <div class="auth-header">
                <div class="back-button" onclick="showPage('login-page')">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <h1 class="header-title">Reset Kata Sandi</h1>
            </div>

            <div class="form-container">
                <div class="form-section">
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h2 class="success-title">Email Terkirim!</h2>
                        <p class="success-description">
                            Tautan untuk reset kata sandi telah dikirim ke email Anda.
                            Silakan periksa kotak masuk atau folder spam.
                        </p>
                        <button class="submit-button" onclick="showPage('login-page')">
                            Kembali ke Halaman Login
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Function to toggle password visibility
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = passwordInput.nextElementSibling.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        // Function to switch between pages
        function showPage(pageId) {
            // Hide all pages
            const pages = document.querySelectorAll(".page");
            pages.forEach((page) => {
                page.classList.remove("active");
            });

            // Show the selected page
            document.getElementById(pageId).classList.add("active");
        }

        // Function to switch between registration tabs
        function switchTab(tabType) {
            const emailTab = document.getElementById("email-tab");
            const phoneTab = document.getElementById("phone-tab");
            const emailForm = document.getElementById("register-form-email");
            const phoneForm = document.getElementById("register-form-phone");

            if (tabType === "email") {
                emailTab.classList.add("active");
                phoneTab.classList.remove("active");
                emailForm.style.display = "block";
                phoneForm.style.display = "none";
            } else {
                emailTab.classList.remove("active");
                phoneTab.classList.add("active");
                emailForm.style.display = "none";
                phoneForm.style.display = "block";
            }
        }
    </script>
</body>

</html>
