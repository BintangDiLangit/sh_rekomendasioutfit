@extends('layouts.app')

@section('content')
    <!-- Search Bar -->
    <div class="search-container mb-4">
        <input type="text" class="search-input form-control" placeholder="Cari Produk" id="search-input">
    </div>

    <!-- Header Image -->
    <div class="container px-4">
        <img src="https://mms.img.susercontent.com/id-11134294-7r98t-lppeligru28fde" alt="Header Background"
            class="header-image w-100 mb-4">

        <!-- Profile Section -->
        <div class="profile-section text-center">
            <img src="https://img.ws.mms.shopee.co.id/id-11134294-7qul9-liu8c7gun4bac1" alt="Profile"
                class="profile-image rounded-circle mb-3" style="width: 150px; height: 150px;">
            <h2 class="mt-3">Rekomendasi Outfit 🌷✨</h2>
            <p class="text-muted">
                ⓘ bisa search/cari di awali sesuai nomor link yang aku cantumln di video ya ✨<br>
                ⓘ tinggal klik yang kamu cari disini~3
            </p>
        </div>

        <!-- Category Buttons -->
        <div class="text-center mb-4">
            <button class="category-button btn btn-outline-primary btn-sm mx-1 active" data-category="all">
                All
            </button>
            @foreach ($categories as $category)
                <button class="category-button btn btn-outline-primary btn-sm mx-1" data-category="{{ $category->id }}">
                    {{ $category->category_name }}
                </button>
            @endforeach
        </div>

        <!-- Product Grid Container -->
        <div class="products-container" id="products-container">
            @foreach ($products as $product)
                <div class="product-card" data-category="{{ $product->category_id }}"
                    data-title="{{ strtolower($product->title) }}">
                    <div class="card">
                        <a href="{{ $product->link }}">
                            <div class="card-img-container">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->title }}">

                            </div>
                        </a>
                        <div class="card-body">
                            <p class="card-title">{{ $product->title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        <div class="load-more text-center mt-4" id="load-more-container"
            style="{{ $products->hasMorePages() ? '' : 'display: none;' }}">
            <button class="load-more-btn btn btn-secondary" id="load-more-btn">
                Load More
                <svg width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                </svg>
            </button>

            <!-- Loading Spinner -->
            <div class="loading-spinner text-center mt-3" id="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadMoreContainer = document.getElementById('load-more-container');
            const productsContainer = document.getElementById('products-container');
            const loadingSpinner = document.getElementById('loading-spinner');

            // Load more products on button click
            loadMoreBtn.addEventListener('click', function() {
                currentPage++;
                loadMoreBtn.style.display = 'none';
                loadingSpinner.style.display = 'block';

                fetch(`{{ route('products.load-more') }}?page=${currentPage}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const temp = document.createElement('div');
                        temp.innerHTML = data.html;

                        while (temp.firstChild) {
                            productsContainer.appendChild(temp.firstChild);
                        }

                        // Check if more products are available
                        if (!data.hasMore) {
                            loadMoreContainer.style.display = 'none';
                        }

                        loadMoreBtn.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadMoreBtn.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-button');
            const productCards = document.querySelectorAll('.product-card');

            // Add event listener to each category button
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.dataset.category;

                    // Update active class for buttons
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Filter products
                    productCards.forEach(card => {
                        if (categoryId === 'all' || card.dataset.category === categoryId) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Grid Layout */
        .products-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 columns */
            gap: 20px;
        }

        /* Crop images */
        .card-img-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Card Hover Effect */
        .product-card {
            transition: transform 0.2s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .products-container {
                grid-template-columns: 1fr;
                /* 1 column for small screens */
            }
        }
    </style>
@endpush
