@foreach ($products as $product)
    <div class="product-card" data-category="{{ $product->category_id }}" data-title="{{ strtolower($product->title) }}">
        <div class="card">
            <a href="{{ $product->link }}">
                <div class="card-img-container">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}">

                </div>
            </a>
            <div class="card-body">
                <p class="card-title">{{ $product->title }}</p>
            </div>
        </div>
    </div>
@endforeach
