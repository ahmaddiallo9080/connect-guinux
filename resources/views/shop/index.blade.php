@extends('layouts.app')
@section('title', $current ? $current->name : 'Boutique')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb"><a href="{{ route('home') }}">Accueil</a> / Boutique{{ $current ? ' / '.$current->name : '' }}</div>
        <h1>{{ $current ? $current->name : 'Boutique' }}</h1>
        <p>Matériel hotspot et réseau disponible chez Guinux Connect. Commandez par WhatsApp ou demandez un devis avec installation.</p>
    </div>
</section>

<section class="section">
    <div class="container shop-layout">
        <aside class="sidebar">
            <h4>Catégories</h4>
            <ul class="cat-list">
                <li><a href="{{ route('shop.index', request()->only('q', 'tri')) }}" class="{{ $current ? '' : 'active' }}">Tous les produits</a></li>
                @foreach($categories as $cat)
                    <li><a href="{{ route('shop.index', array_merge(request()->only('q', 'tri'), ['categorie' => $cat->slug])) }}" class="{{ $current && $current->id === $cat->id ? 'active' : '' }}">{{ $cat->name }} <span>{{ $cat->products_count }}</span></a></li>
                @endforeach
            </ul>
            <h4>Besoin d'aide ?</h4>
            <p style="font-size:14.5px;color:var(--muted)">Pas sûr du matériel à choisir ? Nos techniciens vous conseillent gratuitement.</p>
            <a href="https://wa.me/{{ config('guinux.whatsapp') }}?text={{ rawurlencode('Bonjour, j\'ai besoin de conseils pour choisir mon matériel hotspot.') }}" target="_blank" rel="noopener" class="btn btn--whatsapp btn--sm btn--block">@include('partials.icon', ['name' => 'whatsapp']) Conseil WhatsApp</a>
        </aside>

        <div>
            <form class="toolbar" method="GET" action="{{ route('shop.index') }}">
                @if($current)<input type="hidden" name="categorie" value="{{ $current->slug }}">@endif
                <p>{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }}</p>
                <div class="search">
                    <input class="input" type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit…" style="min-width:220px">
                    <select class="input" name="tri" onchange="this.form.submit()" style="width:auto">
                        <option value="">Pertinence</option>
                        <option value="prix_asc" @selected(request('tri') === 'prix_asc')>Prix croissant</option>
                        <option value="prix_desc" @selected(request('tri') === 'prix_desc')>Prix décroissant</option>
                    </select>
                    <button class="btn btn--primary btn--sm" type="submit" aria-label="Rechercher">@include('partials.icon', ['name' => 'search'])</button>
                </div>
            </form>

            @if($products->isEmpty())
                <div class="empty">
                    @include('partials.icon', ['name' => 'search'])
                    <p>Aucun produit ne correspond à votre recherche.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn--outline btn--sm">Voir tous les produits</a>
                </div>
            @else
                <div class="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                {{ $products->links() }}
            @endif
        </div>
    </div>
</section>
@endsection
