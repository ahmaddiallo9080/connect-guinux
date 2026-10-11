<a href="{{ route('shop.show', $product) }}" class="product-card reveal">
    <div class="product-card__media">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @if(! $product->in_stock)
            <span class="tag tag--out">Rupture</span>
        @elseif($product->is_featured)
            <span class="tag">Populaire</span>
        @endif
        @if($product->discount_percent)
            <span class="tag tag--promo">-{{ $product->discount_percent }}%</span>
        @endif
    </div>
    <div class="product-card__body">
        @if($product->category)
            <div class="product-card__cat">{{ $product->category->name }}</div>
        @endif
        <h3>{{ $product->name }}</h3>
        @if($product->short_description)
            <p>{{ $product->short_description }}</p>
        @endif
        <div class="price">
            <strong>{{ $product->formatted_price }}</strong>
            @if($product->formatted_old_price && $product->discount_percent)
                <del>{{ $product->formatted_old_price }}</del>
            @endif
        </div>
    </div>
</a>
