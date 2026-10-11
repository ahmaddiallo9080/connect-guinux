@extends('layouts.app')
@section('title', $product->name)
@section('description', $product->short_description ?: 'Matériel hotspot disponible chez Guinux Connect.')

@section('content')
@php
    $waMsg = rawurlencode("Bonjour Guinux Connect, je suis intéressé(e) par : {$product->name} ({$product->formatted_price}). ".route('shop.show', $product));
@endphp
<section class="page-hero" style="padding:44px 0 40px">
    <div class="container">
        <div class="breadcrumb" style="margin:0">
            <a href="{{ route('home') }}">Accueil</a> / <a href="{{ route('shop.index') }}">Boutique</a>
            @if($product->category) / <a href="{{ route('shop.index', ['categorie' => $product->category->slug]) }}">{{ $product->category->name }}</a>@endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="product-detail">
            <div class="product-detail__media">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
            <div>
                @if($product->category)<div class="product-card__cat">{{ $product->category->name }}</div>@endif
                <h1>{{ $product->name }}</h1>
                <div class="price">
                    <strong>{{ $product->formatted_price }}</strong>
                    @if($product->discount_percent)
                        <del>{{ $product->formatted_old_price }}</del>
                        <span class="tag tag--promo" style="position:static">-{{ $product->discount_percent }}%</span>
                    @endif
                </div>
                @if($product->in_stock)
                    <div class="stock stock--in">En stock ({{ $product->stock }} disponible{{ $product->stock > 1 ? 's' : '' }})</div>
                @else
                    <div class="stock stock--out">Rupture de stock – contactez-nous pour le réapprovisionnement</div>
                @endif

                @if($product->short_description)<p style="font-size:18px;color:var(--ink)">{{ $product->short_description }}</p>@endif
                @if($product->description)<div class="desc">{{ $product->description }}</div>@endif

                <div class="actions">
                    <a href="https://wa.me/{{ config('guinux.whatsapp') }}?text={{ $waMsg }}" target="_blank" rel="noopener" class="btn btn--whatsapp">@include('partials.icon', ['name' => 'whatsapp']) Commander sur WhatsApp</a>
                    <a href="{{ route('contact', ['produit' => $product->slug]) }}" class="btn btn--outline">@include('partials.icon', ['name' => 'message']) Demander un devis</a>
                </div>

                <div class="perks">
                    <div>@include('partials.icon', ['name' => 'shield']) Matériel neuf et garanti</div>
                    <div>@include('partials.icon', ['name' => 'tool']) Installation et configuration possibles</div>
                    <div>@include('partials.icon', ['name' => 'truck']) Livraison à Conakry et à l'intérieur du pays</div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->isNotEmpty())
<section class="section section--soft">
    <div class="container">
        <div class="section-head"><span class="eyebrow">À découvrir aussi</span><h2>Produits similaires</h2></div>
        <div class="products-grid">
            @foreach($related as $item)
                @include('partials.product-card', ['product' => $item])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
