<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enchanted Trinkets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .search-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .search-input {
            border-radius: 25px;
            padding: 12px 25px;
            border: 1px solid #dee2e6;
            width: 100%;
            background-color: white;
        }

        .header-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-top: -50px;
            border: 3px solid white;
            background-color: #98D8AA;
        }

        .category-button {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 8px 20px;
            margin: 5px;
            text-decoration: none;
            color: #333;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .category-button:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        /* Product Row Styling */
        .product-row {
            display: flex;
            margin-bottom: 20px;
            gap: 20px;
        }

        .product-card {
            flex: 1;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
            background: white;
            border: 1px solid #dee2e6;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        .product-title {
            padding: 15px;
            margin: 0;
            font-size: 0.9rem;
            color: #333;
        }

        .load-more {
            text-align: center;
            margin: 30px 0;
        }

        .load-more-btn {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .product-row {
                flex-direction: column;
                gap: 15px;
            }

            .product-image {
                aspect-ratio: 16/9;
            }

            .product-card {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Cari Link">
    </div>

    <!-- Header Image -->
    <div class="container px-4">
        <img src="https://mms.img.susercontent.com/id-11134294-7r98t-lppeligru28fde" alt="Header Background"
            class="header-image">

        <!-- Profile Section -->
        <div class="profile-section">
            <img src="https://img.ws.mms.shopee.co.id/id-11134294-7qul9-liu8c7gun4bac1" alt="Profile"
                class="profile-image">
            <h2 class="mt-3">enchanted trinkets 🌷✨</h2>
            <p class="text-muted">
                ⓘ bisa search/cari di awali sesuai nomor link yang aku cantumln di video ya ✨<br>
                ⓘ tinggal klik yang kamu cari disini~3
            </p>
        </div>

        <!-- Category Buttons -->
        <div class="text-center mb-4">
            <a href="#" class="category-button">aesthetic stuff ❀3°</a>
            <a href="#" class="category-button">outfit 🌷 💌</a>
        </div>

        <!-- Product Grid - Always 2 per row -->
        <div class="products-container">
            <!-- Row 1 -->
            <div class="product-row">
                <div class="product-card">
                    <img src="/api/placeholder/400/400" alt="Moon Clock" class="product-image">
                    <h3 class="product-title">411. Moon clock</h3>
                </div>
                <div class="product-card">
                    <img src="/api/placeholder/400/400" alt="Planet Crystal Lamp" class="product-image">
                    <h3 class="product-title">410. planet crystal lamp</h3>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="product-row">
                <div class="product-card">
                    <img src="/api/placeholder/400/400" alt="Space Toy" class="product-image">
                    <h3 class="product-title">409. Space Themed Toy</h3>
                </div>
                <div class="product-card">
                    <img src="/api/placeholder/400/400" alt="Decorative Item" class="product-image">
                    <h3 class="product-title">408. Decorative Collection</h3>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more">
            <button class="load-more-btn">
                Lebih Banyak
                <svg width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                </svg>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
