@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="container">
        <div>
            <span class="eyebrow" style="color:#7fd3ff">Spécialiste hotspot WiFi en Guinée</span>
            <h1>Installez, gérez et dépannez votre <em>hotspot WiFi</em></h1>
            <p class="lead">Matériel réseau de qualité, installation clé en main et intervention rapide en cas de panne. Guinux Connect connecte vos clients, votre quartier et votre business.</p>
            <div class="hero__actions">
                <a href="{{ route('shop.index') }}" class="btn btn--white">@include('partials.icon', ['name' => 'box']) Voir la boutique</a>
                <a href="https://wa.me/{{ config('guinux.whatsapp') }}?text={{ rawurlencode('Bonjour, j\'ai besoin d\'un dépannage hotspot.') }}" target="_blank" rel="noopener" class="btn btn--ghost">@include('partials.icon', ['name' => 'tool']) Demander un dépannage</a>
            </div>
            <div class="hero__badges">
                <span>@include('partials.icon', ['name' => 'shield']) Matériel garanti</span>
                <span>@include('partials.icon', ['name' => 'clock']) Intervention rapide</span>
                <span>@include('partials.icon', ['name' => 'truck']) Livraison à Conakry</span>
            </div>
        </div>
        <div class="hero__visual" aria-hidden="true">
            <span class="ring"></span><span class="ring"></span><span class="ring"></span>
            <div class="orb"><img src="{{ asset('images/logo-icon.png') }}" alt=""></div>
            <div class="hero__chip hero__chip--a"><span class="dot">@include('partials.icon', ['name' => 'wifi'])</span><div>Réseau en ligne<small>Signal stable 24h/24</small></div></div>
            <div class="hero__chip hero__chip--b"><span class="dot">@include('partials.icon', ['name' => 'check'])</span><div>Panne résolue<small>Technicien sur place</small></div></div>
        </div>
    </div>
</section>

<div class="stats">
    <div class="container">
        <div class="stats__grid">
            <div class="stat"><strong data-count="150" data-suffix="+">150+</strong><span>Hotspots installés</span></div>
            <div class="stat"><strong data-count="{{ $productCount }}">{{ $productCount }}</strong><span>Produits en boutique</span></div>
            <div class="stat"><strong data-count="24" data-suffix="h">24h</strong><span>Délai d'intervention</span></div>
            <div class="stat"><strong data-count="98" data-suffix="%">98%</strong><span>Clients satisfaits</span></div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow">Nos services</span>
            <h2>Tout pour un hotspot qui fonctionne, du matériel au dépannage</h2>
            <p>Un seul interlocuteur pour équiper, installer et entretenir votre réseau WiFi.</p>
        </div>
        <div class="services-grid">
            <div class="service reveal">
                <div class="service__icon">@include('partials.icon', ['name' => 'router'])</div>
                <h3>Vente de matériel</h3>
                <p>Routeurs, points d'accès, antennes, câbles et onduleurs sélectionnés pour durer.</p>
            </div>
            <div class="service reveal">
                <div class="service__icon">@include('partials.icon', ['name' => 'wifi'])</div>
                <h3>Installation hotspot</h3>
                <p>Étude du site, pose des équipements et mise en service clé en main.</p>
            </div>
            <div class="service reveal">
                <div class="service__icon">@include('partials.icon', ['name' => 'tool'])</div>
                <h3>Dépannage & maintenance</h3>
                <p>Diagnostic, réparation et remise en ligne rapide de votre site hotspot.</p>
            </div>
            <div class="service reveal">
                <div class="service__icon">@include('partials.icon', ['name' => 'settings'])</div>
                <h3>Configuration</h3>
                <p>Paramétrage MikroTik, gestion des tickets WiFi et des utilisateurs.</p>
            </div>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow">Boutique</span>
            <h2>Le matériel le plus demandé</h2>
            <p>Des équipements testés par nos techniciens sur le terrain.</p>
        </div>

        @if($categories->isNotEmpty())
            <div class="chips">
                @foreach($categories->where('products_count', '>', 0) as $cat)
                    <a class="chip" href="{{ route('shop.index', ['categorie' => $cat->slug]) }}">{{ $cat->name }} ({{ $cat->products_count }})</a>
                @endforeach
            </div>
        @endif

        @if($featured->isEmpty())
            <div class="empty">@include('partials.icon', ['name' => 'box'])<p>Les produits arrivent bientôt.</p></div>
        @else
            <div class="products-grid">
                @foreach($featured as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif

        <div style="text-align:center;margin-top:40px">
            <a href="{{ route('shop.index') }}" class="btn btn--primary">Voir tous les produits @include('partials.icon', ['name' => 'arrow'])</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Comment ça marche</span>
            <h2>Votre hotspot en ligne en 4 étapes</h2>
        </div>
        <div class="steps">
            <div class="step reveal"><h3>Prise de contact</h3><p>Vous nous décrivez votre projet ou votre panne par téléphone, WhatsApp ou formulaire.</p></div>
            <div class="step reveal"><h3>Étude & devis</h3><p>Nous évaluons la zone à couvrir et vous proposons le matériel adapté à votre budget.</p></div>
            <div class="step reveal"><h3>Installation</h3><p>Nos techniciens posent et configurent les équipements, tickets WiFi compris.</p></div>
            <div class="step reveal"><h3>Suivi</h3><p>Maintenance, assistance et dépannage rapide pour garder votre réseau en ligne.</p></div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="cta reveal">
            <div>
                <h2>Votre hotspot ne fonctionne plus ?</h2>
                <p>Un technicien vous répond rapidement pour diagnostiquer et réparer.</p>
            </div>
            <div class="btns">
                <a href="https://wa.me/{{ config('guinux.whatsapp') }}?text={{ rawurlencode('Bonjour, mon hotspot a un problème.') }}" target="_blank" rel="noopener" class="btn btn--white">@include('partials.icon', ['name' => 'whatsapp']) WhatsApp</a>
                <a href="tel:{{ preg_replace('/\s+/', '', config('guinux.phone')) }}" class="btn btn--ghost">@include('partials.icon', ['name' => 'phone']) Appeler</a>
            </div>
        </div>
    </div>
</section>
@endsection
