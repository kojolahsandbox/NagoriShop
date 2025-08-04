<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Halaman Tidak Ditemukan | Kodai Nagori</title>
    <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}">
</head>

<body>
    <div class="container">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element">🛒</div>
            <div class="floating-element">🍖</div>
            <div class="floating-element">🥚</div>
            <div class="floating-element">🐟</div>
        </div>

        <div class="error-content">
            <div class="error-icon">
                🛍️
            </div>

            <div class="error-code">404</div>

            <h1 class="error-title">Halaman/Produk<br /> Tidak Ditemukan</h1>

            <p class="error-message">
                Maaf, halaman/produk yang Anda cari tidak dapat ditemukan.
            </p>

            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i>
                    Kembali ke Beranda
                </a>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                    Halaman Sebelumnya
                </a>
            </div>

            <div class="search-suggestion">
                <div class="search-title">🔍 Cari Produk yang Anda Inginkan</div>

                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" class="search-input" placeholder="Cari produk favorit Anda..."
                        onkeypress="handleSearch(event)" />
                </div>

                <div class="popular-categories">
                    <div class="category-title">Kategori Populer:</div>
                    <div class="category-tags">
                        <a href="{{ url('/sapi') }}" class="category-tag">🐄 Sapi</a>
                        <a href="{{ url('/telur') }}" class="category-tag">🥚 Telur</a>
                        <a href="{{ url('/sayur') }}" class="category-tag">🌶️ Sayur</a>
                        <a href="{{ url('/bua') }}h" class="category-tag">🍋 Buah</a>
                        <a href="{{ url('/ayam') }}" class="category-tag">🍗 Ayam</a>
                        <a href="{{ url('/ikan') }}" class="category-tag">🐟 Ikan</a>
                        <a href="{{ url('/rempah') }}" class="category-tag">🌿 Rempah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Search functionality
        function handleSearch(event) {
            if (event.key === 'Enter') {
                const searchTerm = event.target.value.trim();
                if (searchTerm) {
                    // Redirect to main page with search parameter
                    window.location.href = `index.html?search=${encodeURIComponent(searchTerm)}`;
                }
            }
        }

        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to category tags
            const categoryTags = document.querySelectorAll('.category-tag');
            categoryTags.forEach(tag => {
                tag.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.textContent.trim();
                    window.location.href = `index.html?category=${encodeURIComponent(category)}`;
                });
            });

            // Add some sparkle effect on mouse move
            document.addEventListener('mousemove', function(e) {
                if (Math.random() > 0.98) {
                    createSparkle(e.clientX, e.clientY);
                }
            });
        });

        function createSparkle(x, y) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'fixed';
            sparkle.style.left = x + 'px';
            sparkle.style.top = y + 'px';
            sparkle.style.color = 'white';
            sparkle.style.fontSize = '12px';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '1000';
            sparkle.innerHTML = '✨';
            sparkle.style.animation = 'sparkleAnimation 1s ease-out forwards';

            document.body.appendChild(sparkle);

            setTimeout(() => {
                document.body.removeChild(sparkle);
            }, 1000);
        }

        // Add sparkle animation
        const style = document.createElement('style');
        style.textContent = `
        @keyframes sparkleAnimation {
          0% {
            opacity: 1;
            transform: translateY(0) scale(1);
          }
          100% {
            opacity: 0;
            transform: translateY(-30px) scale(0.5);
          }
        }
      `;
        document.head.appendChild(style);
    </script>
</body>

</html>
