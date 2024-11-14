<!-- resources/views/products/load-more.blade.php -->
@foreach ($products->chunk(2) as $chunk)
    <div class="product-row">
        @foreach ($chunk as $product)
            <div class="product-card">
                <a href="{{ $product->link }}" target="_blank">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                    <h3 class="product-title">
                        {{ $product->product_number }}. {{ $product->title }}
                    </h3>
                </a>
            </div>
        @endforeach
        @if ($chunk->count() === 1)
            <div class="product-card" style="visibility: hidden;">
                <img src="/api/placeholder/400/400" alt="" class="product-image">
                <h3 class="product-title">&nbsp;</h3>
            </div>
        @endif
    </div>
@endforeach
