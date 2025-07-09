<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }} - Nagori Shop</title>
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="javascript:history.back()" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="header-title">Profil Saya</h1>
        </div>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar" onclick="changeProfilePicture()">
                <span id="profileInitial">JD</span>
                <div class="camera-overlay">
                    <i class="fa-solid fa-camera"></i>
                </div>
            </div>
            <div class="profile-name" id="profileName">John Doe</div>
            <div class="profile-email" id="profileEmail">john.doe@example.com</div>
            @if (session('success'))
                <div style="color:#980000;">
                    {{ session('success') }}
                </div>
            @endif

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
        </div>

        <!-- Order & Activity -->
        <div class="section-title">Pesanan & Aktivitas</div>
        <div class="menu-section">
            <a href="#" class="menu-item" onclick="openOrdersModal()">
                <div class="menu-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div class="menu-text">Pesanan Saya</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
        </div>

        <!-- Account Settings -->
        <div class="section-title">Pengaturan Akun</div>
        <div class="menu-section">
            <a href="#" class="menu-item" onclick="openEditProfileModal()">
                <div class="menu-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="menu-text">Edit Profil</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
            <a href="#" class="menu-item" onclick="openChangePasswordModal()">
                <div class="menu-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="menu-text">Ganti Password</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
            <a href="#" class="menu-item" onclick="openNotificationsModal()">
                <div class="menu-icon">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div class="menu-text">Notifikasi</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
        </div>

        <!-- Help & Support -->
        <div class="section-title">Bantuan & Dukungan</div>
        <div class="menu-section">
            <a href="https://wa.me/62811662373?text=Saya+Butuh+Bantuan+Aplikasi+".{{ env('APP_URL') }}
                class="menu-item">
                <div class="menu-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div class="menu-text">Customer Service</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon">
                    <i class="fa-solid fa-question-circle"></i>
                </div>
                <div class="menu-text">FAQ</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon">
                    <i class="fa-solid fa-shield-alt"></i>
                </div>
                <div class="menu-text">Kebijakan Privasi</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
        </div>

        <!-- Logout -->
        <div class="menu-section" style="margin-top: 20px">
            <a href="{{ route('logout') }}" class="menu-item logout-item" onclick="logout()">
                <div class="menu-icon">
                    <i class="fa-solid fa-sign-out-alt"></i>
                </div>
                <div class="menu-text">Keluar</div>
                <div class="menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>
        </div>

        <div style="height: 80px"></div>

        <!-- Bottom Navigation -->
        <div class="menu-bar">
            <a href="{{ url('/') }}" class="menu-item-bottom">
                <div class="menu-icon-bottom">
                    <i class="fa-solid fa-house"></i>
                </div>
                <span>Beranda</span>
            </a>
            <a href="#" class="menu-item-bottom">
                <div class="menu-icon-bottom">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <span>Trending</span>
            </a>
            <a href="#" class="menu-item-bottom">
                <div class="menu-icon-bottom">
                    <i class="fa-solid fa-video"></i>
                </div>
                <span>Live & Video</span>
            </a>
            <a href="#" class="menu-item-bottom notification-badge">
                <div class="menu-icon-bottom">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <span class="notif-badge">46</span>
                <span>Notifikasi</span>
            </a>
            <a href="#" class="menu-item-bottom active">
                <div class="menu-icon-bottom">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span>Saya</span>
            </a>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Ganti Password</h2>
                <button class="close-btn" onclick="closeModal('changePasswordModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <div class="password-toggle">
                            <input type="password" name="current_password" class="form-input" id="oldPassword"
                                required />
                            <button type="button" class="toggle-password" onclick="togglePassword('oldPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="oldPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="password-toggle">
                            <input type="password" name="password" class="form-input" id="newPassword" required />
                            <button type="button" class="toggle-password" onclick="togglePassword('newPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="newPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-toggle">
                            <input type="password" name="password_confirmation" class="form-input"
                                id="confirmPassword" required />
                            <button type="button" class="toggle-password"
                                onclick="togglePassword('confirmPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Password</button>
                    <div class="success-message" id="passwordSuccessMessage">
                        Password berhasil diubah!
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Modal -->
    <div id="ordersModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Pesanan Saya</h2>
                <button class="close-btn" onclick="closeModal('ordersModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterOrders('all')">
                    Semua
                </button>
                <button class="filter-tab" onclick="filterOrders('pending')">
                    Menunggu
                </button>
                <button class="filter-tab" onclick="filterOrders('shipped')">
                    Dikirim
                </button>
                <button class="filter-tab" onclick="filterOrders('delivered')">
                    Selesai
                </button>
            </div>
            <div class="modal-body modal-body-scrollable" id="ordersContent">
                <!-- Orders will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    <div id="notificationsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Notifikasi</h2>
                <button class="close-btn" onclick="closeModal('notificationsModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterNotifications('all')">
                    Semua
                </button>
                <button class="filter-tab" onclick="filterNotifications('order')">
                    Pesanan
                </button>
                <button class="filter-tab" onclick="filterNotifications('promo')">
                    Promo
                </button>
                <button class="filter-tab" onclick="filterNotifications('system')">
                    Sistem
                </button>
            </div>
            <div class="modal-body modal-body-scrollable" id="notificationsContent">
                <!-- Notifications will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Profil</h2>
                <button class="close-btn" onclick="closeModal('editProfileModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <form id="editProfileForm" method="POST" action="{{ route('profile_update') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" id="editName" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" id="editEmail" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="phone" required class="form-input" id="editPhone" />
                    </div>
                    <!-- Address fields with API -->
                    <div class="form-group">
                        <label class="form-label">Provinsi</label>
                        <select id="provinsi" name="province" class="form-input" required></select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kota/Kabupaten</label>
                        <select id="kota" name="city" class="form-input" required></select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kecamatan</label>
                        <select id="kecamatan" name="district" class="form-input" required></select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelurahan</label>
                        <select id="kelurahan" name="village" class="form-input" name="address" required></select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <input id="editAddress" name="address" class="form-input" name="address" required></input>
                    </div>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <div class="success-message" id="profileSuccessMessage">
                        Profil berhasil diperbarui!
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Sample orders data
        const ordersData = @json($purchasedItems);

        // Sample notifications data
        const notificationsData = [{
                id: 1,
                type: "order",
                title: "Pesanan Terkirim",
                message: "Pesanan #NG001234 telah sampai di tujuan. Jangan lupa berikan rating!",
                time: "2 jam lalu",
                unread: true,
            },
            {
                id: 2,
                type: "promo",
                title: "Flash Sale Dimulai!",
                message: "Dapatkan diskon hingga 50% untuk produk pilihan. Buruan sebelum kehabisan!",
                time: "4 jam lalu",
                unread: true,
            },
            {
                id: 3,
                type: "order",
                title: "Pesanan Sedang Dikirim",
                message: "Pesanan #NG001235 sedang dalam perjalanan ke alamat Anda.",
                time: "1 hari lalu",
                unread: false,
            },
            {
                id: 4,
                type: "system",
                title: "Update Aplikasi Tersedia",
                message: "Versi terbaru aplikasi Nagori Shop telah tersedia dengan fitur-fitur menarik.",
                time: "2 hari lalu",
                unread: false,
            },
            {
                id: 5,
                type: "promo",
                title: "Cashback Spesial",
                message: "Dapatkan cashback 10% untuk pembelian minimal Rp100.000. Berlaku sampai akhir bulan!",
                time: "3 hari lalu",
                unread: false,
            },
        ];

        // Open orders modal
        function openOrdersModal() {
            document.getElementById("ordersModal").classList.add("show");
            loadOrders("all");
        }

        // Open notifications modal
        function openNotificationsModal() {
            document.getElementById("notificationsModal").classList.add("show");
            loadNotifications("all");
        }

        // Load orders based on filter
        function loadOrders(filter) {
            const ordersContent = document.getElementById("ordersContent");
            let filteredOrders = ordersData;

            if (filter !== "all") {
                filteredOrders = ordersData.filter(
                    (order) => order.statusLabel === filter
                );
            }

            if (filteredOrders.length === 0) {
                ordersContent.innerHTML = `
                        <div class="empty-state">
                            <i class="fa-solid fa-box-open"></i>
                            <h3>Tidak ada pesanan</h3>
                            <p>Belum ada pesanan untuk kategori ini</p>
                        </div>
                    `;
                return;
            }

            ordersContent.innerHTML = filteredOrders
                .map(
                    (order) => `
                    <div class="order-item">
                        <a style="text-decoration:none;" href="/checkout/${order.order_id}">
                        <div class="order-header">
                            <span class="order-id">#${order.id}</span>
                            <span class="order-status status-${order.statusLabel}">${order.status}</span>
                        </div>
                        <div class="order-details">
                            <img src="${order.image}" alt="${order.product}" class="order-image">
                            <div class="order-info">
                                <div class="order-product">${order.product}</div>
                                <div class="order-price">${order.price}</div>
                            </div>
                        </div>
                        <div class="order-date">${order.date}</div>
                        </a>
                    </div>
                `
                )
                .join("");
        }

        // Load notifications based on filter
        function loadNotifications(filter) {
            const notificationsContent = document.getElementById(
                "notificationsContent"
            );
            let filteredNotifications = notificationsData;

            if (filter !== "all") {
                filteredNotifications = notificationsData.filter(
                    (notification) => notification.type === filter
                );
            }

            if (filteredNotifications.length === 0) {
                notificationsContent.innerHTML = `
                        <div class="empty-state">
                            <i class="fa-solid fa-bell-slash"></i>
                            <h3>Tidak ada notifikasi</h3>
                            <p>Belum ada notifikasi untuk kategori ini</p>
                        </div>
                    `;
                return;
            }

            notificationsContent.innerHTML = filteredNotifications
                .map(
                    (notification) => `
                    <div class="notification-item ${
                      notification.unread ? "notification-unread" : ""
                    }">
                        <div class="notification-header">
                            <div class="notification-icon notif-${
                              notification.type
                            }">
                                <i class="fa-solid fa-${getNotificationIcon(
                                  notification.type
                                )}"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">${
                                  notification.title
                                }</div>
                                <div class="notification-message">${
                                  notification.message
                                }</div>
                                <div class="notification-time">${
                                  notification.time
                                }</div>
                            </div>
                            ${
                              notification.unread
                                ? '<div class="notification-dot"></div>'
                                : ""
                            }
                        </div>
                    </div>
                `
                )
                .join("");
        }

        // Get notification icon based on type
        function getNotificationIcon(type) {
            const icons = {
                order: "box",
                promo: "tag",
                system: "gear",
            };
            return icons[type] || "bell";
        }

        // Filter orders
        function filterOrders(filter) {
            // Update active tab
            document.querySelectorAll("#ordersModal .filter-tab").forEach((tab) => {
                tab.classList.remove("active");
            });
            event.target.classList.add("active");

            // Load filtered orders
            loadOrders(filter);
        }

        // Filter notifications
        function filterNotifications(filter) {
            // Update active tab
            document
                .querySelectorAll("#notificationsModal .filter-tab")
                .forEach((tab) => {
                    tab.classList.remove("active");
                });
            event.target.classList.add("active");

            // Load filtered notifications
            loadNotifications(filter);
        }
        let userData = {
            name: "{{ auth()->user()->name }}",
            email: "{{ auth()->user()->email }}",
            phone: "{{ auth()->user()->phone }}",
            address: "{{ auth()->user()->address }}",
        };

        // Initialize profile
        function initializeProfile() {
            document.getElementById("profileName").textContent = userData.name;
            document.getElementById("profileEmail").textContent = userData.email;

            // Generate initials
            const initials = generateInitials(userData.name);
            document.getElementById("profileInitial").textContent = initials;

            // Fill edit form
            document.getElementById("editName").value = userData.name;
            document.getElementById("editEmail").value = userData.email;
            document.getElementById("editPhone").value = userData.phone;
            document.getElementById("editAddress").value = userData.address;
        }

        // Generate initials from name
        function generateInitials(name) {
            return name
                .split(" ")
                .map((word) => word.charAt(0).toUpperCase())
                .slice(0, 2)
                .join("");
        }

        // Modal functions
        function openChangePasswordModal() {
            document.getElementById("changePasswordModal").classList.add("show");
        }

        function openEditProfileModal() {
            document.getElementById("editProfileModal").classList.add("show");
            // Ensure form is populated with current user data
            document.getElementById("editName").value = userData.name;
            document.getElementById("editEmail").value = userData.email;
            document.getElementById("editPhone").value = userData.phone;
            document.getElementById("editAddress").value = userData.address;
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove("show");
            // Only clear password form, not profile form
            if (modalId === "changePasswordModal") {
                clearForm(modalId);
            }
        }

        function clearForm(modalId) {
            const form = document.querySelector(`#${modalId} form`);
            if (form) {
                form.reset();
                // Hide error and success messages
                const errorMessages = form.querySelectorAll(".error-message");
                const successMessages = form.querySelectorAll(".success-message");
                errorMessages.forEach((msg) => (msg.style.display = "none"));
                successMessages.forEach((msg) => (msg.style.display = "none"));
            }
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Validate password
        function validatePassword(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);

            if (password.length < minLength) {
                return "Password minimal 8 karakter";
            }
            if (!hasUpperCase) {
                return "Password harus mengandung huruf besar";
            }
            if (!hasLowerCase) {
                return "Password harus mengandung huruf kecil";
            }
            if (!hasNumbers) {
                return "Password harus mengandung angka";
            }
            return null;
        }

        // Show error message
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.style.display = "block";
        }

        // Hide error message
        function hideError(elementId) {
            const errorElement = document.getElementById(elementId);
            errorElement.style.display = "none";
        }

        // Change password form handler
        document
            .getElementById("changePasswordForm")
            .addEventListener("submit", function(e) {
                // e.preventDefault();

                const oldPassword = document.getElementById("oldPassword").value;
                const newPassword = document.getElementById("newPassword").value;
                const confirmPassword =
                    document.getElementById("confirmPassword").value;

                // Clear previous errors
                hideError("oldPasswordError");
                hideError("newPasswordError");
                hideError("confirmPasswordError");

                let hasError = false;

                // Validate old password (in real app, verify against server)
                if (oldPassword.length < 1) {
                    showError("oldPasswordError", "Password lama wajib diisi");
                    hasError = true;
                }

                // Validate new password
                const passwordError = validatePassword(newPassword);
                if (passwordError) {
                    showError("newPasswordError", passwordError);
                    hasError = true;
                }

                // Validate password confirmation
                if (newPassword !== confirmPassword) {
                    showError(
                        "confirmPasswordError",
                        "Konfirmasi password tidak cocok"
                    );
                    hasError = true;
                }

                if (!hasError) {
                    // Simulate API call
                    setTimeout(() => {
                        document.getElementById("passwordSuccessMessage").style.display =
                            "block";
                        setTimeout(() => {
                            closeModal("changePasswordModal");
                        }, 2000);
                    }, 1000);
                }
            });

        // Edit profile form handler
        // api address
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

            const provinsiSelect = document.getElementById('provinsi');
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');

            // Store user's address data
            const userAddress = {
                province: "{{ auth()->user()->province ?? '' }}",
                city: "{{ auth()->user()->city ?? '' }}",
                district: "{{ auth()->user()->district ?? '' }}",
                village: "{{ auth()->user()->village ?? '' }}"
            };

            // Load Provinsi
            fetch(`${baseUrl}/provinces.json`)
                .then(res => res.json())
                .then(data => {
                    provinsiSelect.innerHTML = `<option value="">Pilih Provinsi</option>`;
                    data.forEach(prov => {
                        const selected = prov.id == userAddress.province ? 'selected' : '';
                        provinsiSelect.innerHTML +=
                            `<option value="${prov.id}" ${selected}>${prov.name}</option>`;
                    });

                    // If province is set, trigger change to load cities
                    if (userAddress.province) {
                        provinsiSelect.dispatchEvent(new Event('change'));
                    }
                });

            provinsiSelect.addEventListener('change', function() {
                fetch(`${baseUrl}/regencies/${this.value}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kotaSelect.innerHTML = `<option value="">Pilih Kota/Kabupaten</option>`;
                        kecamatanSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kota => {
                            const selected = kota.id == userAddress.city ? 'selected' : '';
                            kotaSelect.innerHTML +=
                                `<option value="${kota.id}" ${selected}>${kota.name}</option>`;
                        });

                        // If city is set, trigger change to load districts
                        if (userAddress.city) {
                            kotaSelect.dispatchEvent(new Event('change'));
                        }
                    });
            });

            kotaSelect.addEventListener('change', function() {
                fetch(`${baseUrl}/districts/${this.value}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kecamatanSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kec => {
                            const selected = kec.id == userAddress.district ? 'selected' : '';
                            kecamatanSelect.innerHTML +=
                                `<option value="${kec.id}" ${selected}>${kec.name}</option>`;
                        });

                        // If district is set, trigger change to load villages
                        if (userAddress.district) {
                            kecamatanSelect.dispatchEvent(new Event('change'));
                        }
                    });
            });

            kecamatanSelect.addEventListener('change', function() {
                fetch(`${baseUrl}/villages/${this.value}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kel => {
                            const selected = kel.id == userAddress.village ? 'selected' : '';
                            kelurahanSelect.innerHTML +=
                                `<option value="${kel.id}" ${selected}>${kel.name}</option>`;
                        });
                    });
            });
        });

        // Change profile picture
        function changeProfilePicture() {
            // In a real app, this would open file picker or camera
            alert("Fitur ganti foto profil akan segera tersedia!");
        }

        // Logout function
        function logout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                // In real app, clear session and redirect to login
                alert("Anda telah keluar dari aplikasi");
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll(".modal");
            modals.forEach((modal) => {
                if (event.target === modal) {
                    modal.classList.remove("show");
                }
            });
        };

        // Initialize when page loads
        document.addEventListener("DOMContentLoaded", function() {
            initializeProfile();
        });
    </script>
    </div>

</body>

</html>
