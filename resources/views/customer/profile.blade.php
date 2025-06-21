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

        <!-- Help & Support -->
        <div class="section-title">Bantuan & Dukungan</div>
        <div class="menu-section">
            <a href="#" class="menu-item">
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
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <div class="password-toggle">
                            <input type="password" class="form-input" id="oldPassword" required />
                            <button type="button" class="toggle-password" onclick="togglePassword('oldPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="oldPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="password-toggle">
                            <input type="password" class="form-input" id="newPassword" required />
                            <button type="button" class="toggle-password" onclick="togglePassword('newPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="newPasswordError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-toggle">
                            <input type="password" class="form-input" id="confirmPassword" required />
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
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Profil</h2>
                <button class="close-btn" onclick="closeModal('editProfileModal')">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" id="editName" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" id="editEmail" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-input" id="editPhone" />
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
        const ordersData = [{
                id: "NG001234",
                product: "Ikan Kering Premium",
                price: "Rp87.040",
                status: "delivered",
                statusText: "Terkirim",
                date: "15 Jun 2025",
                image: "https://www.claudeusercontent.com/api/placeholder/50/50",
            },
            {
                id: "NG001235",
                product: "Lado Merah Giliang",
                price: "Rp36.224",
                status: "shipped",
                statusText: "Dikirim",
                date: "20 Jun 2025",
                image: "https://www.claudeusercontent.com/api/placeholder/50/50",
            },
            {
                id: "NG001236",
                product: "Ikan Nila Segar",
                price: "Rp14.400",
                status: "processing",
                statusText: "Diproses",
                date: "21 Jun 2025",
                image: "https://www.claudeusercontent.com/api/placeholder/50/50",
            },
            {
                id: "NG001237",
                product: "Sapi Kurban A5",
                price: "Rp1.336.224",
                status: "pending",
                statusText: "Menunggu",
                date: "21 Jun 2025",
                image: "https://www.claudeusercontent.com/api/placeholder/50/50",
            },
        ];

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
                    (order) => order.status === filter
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
                    <div class="order-header">
                        <span class="order-id">#${order.id}</span>
                        <span class="order-status status-${order.status}">${order.statusText}</span>
                    </div>
                    <div class="order-details">
                        <img src="${order.image}" alt="${order.product}" class="order-image">
                        <div class="order-info">
                            <div class="order-product">${order.product}</div>
                            <div class="order-price">${order.price}</div>
                        </div>
                    </div>
                    <div class="order-date">${order.date}</div>
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
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove("show");
            clearForm(modalId);
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
                e.preventDefault();

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
        document
            .getElementById("editProfileForm")
            .addEventListener("submit", function(e) {
                e.preventDefault();

                const newName = document.getElementById("editName").value;
                const newEmail = document.getElementById("editEmail").value;
                const newPhone = document.getElementById("editPhone").value;

                // Update user data
                userData.name = newName;
                userData.email = newEmail;
                userData.phone = newPhone;

                // Update UI
                document.getElementById("profileName").textContent = newName;
                document.getElementById("profileEmail").textContent = newEmail;
                document.getElementById("profileInitial").textContent =
                    generateInitials(newName);

                // Show success message
                document.getElementById("profileSuccessMessage").style.display =
                    "block";
                setTimeout(() => {
                    closeModal("editProfileModal");
                }, 2000);
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
</body>

</html>
