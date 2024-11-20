<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Enchanted Trinkets') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Base Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
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

        .category-button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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

        .product-card a {
            text-decoration: none;
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
            padding: 10px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .load-more-btn:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .loading-spinner {
            text-align: center;
            padding: 20px;
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

            .header-image {
                height: 200px;
            }
        }

        /* Animation Classes */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .slide-up {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 0.5s ease forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Additional Styles Stack -->
    @stack('styles')
</head>

<body>
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Optional Footer -->
    <footer class="text-center py-4 mt-4 text-muted">
        <small>&copy; {{ date('Y') }} Enchanted Trinkets. All rights reserved.</small>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts Stack -->
    @stack('scripts')

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
</body>

</html>
