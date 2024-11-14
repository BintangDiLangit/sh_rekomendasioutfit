<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
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
            <img src="https://img.ws.mms.shopee.co.id/id-11134294-7qul9-liu8c7gun4bac1" alt="Profile" class="profile-image">
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

        <!-- Product Grid Container -->
        <div class="products-container" id="products-container">
            @include('products.load-more', ['products' => $products])
        </div>

        <!-- Load More Button -->
        <div class="load-more" id="load-more-container" style="{{ $products->hasMorePages() ? '' : 'display: none;' }}">
            <button class="load-more-btn" id="load-more-btn">
                Lebih Banyak
                <svg width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                </svg>
            </button>

            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .loading-spinner {
            text-align: center;
            padding: 20px;
        }

        .product-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            let isLoading = false;
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadMoreContainer = document.getElementById('load-more-container');
            const productsContainer = document.getElementById('products-container');
            const loadingSpinner = document.getElementById('loading-spinner');

            loadMoreBtn.addEventListener('click', function() {
                if (isLoading) return;

                isLoading = true;
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
                        // Create temporary container
                        const temp = document.createElement('div');
                        temp.innerHTML = data.html;

                        // Append new products
                        while (temp.firstChild) {
                            productsContainer.appendChild(temp.firstChild);
                        }

                        // Update visibility of load more button
                        if (!data.hasMore) {
                            loadMoreContainer.style.display = 'none';
                        }

                        isLoading = false;
                        loadMoreBtn.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        isLoading = false;
                        loadMoreBtn.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    });
            });

            // Optional: Infinite scroll
            function handleInfiniteScroll() {
                const endOfPage = window.innerHeight + window.pageYOffset >= document.body.offsetHeight - 100;

                if (endOfPage && !isLoading && loadMoreContainer.style.display !== 'none') {
                    loadMoreBtn.click();
                }
            }

            // Uncomment below if you want infinite scroll
            // window.addEventListener('scroll', handleInfiniteScroll);
        });
    </script>
@endpush
