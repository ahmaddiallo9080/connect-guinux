<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · @endif Guinux Connect</title>
    <meta name="description" content="@yield('description', 'Guinux Connect : vente et installation de matériel hotspot WiFi, dépannage et maintenance de sites hotspot en Guinée.')">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=1">
</head>
<body>
@php
    $wa = config('guinux.whatsapp');
    $waText = rawurlencode('Bonjour Guinux Connect, je souhaite des informations.');
@endphp

<div class="topbar">
    <div class="container">
        <span>@include('partials.icon', ['name' => 'map']) {{ config('guinux.address') }}</span>
        <div style="display:flex;gap:18px">
            <span class="hide-sm">@include('partials.icon', ['name' => 'mail']) <a href="mailto:{{ config('guinux.email') }}">{{ config('guinux.email') }}</a></span>
            <span>@include('partials.icon', ['name' => 'phone']) <a href="tel:{{ preg_replace('/\s+/', '', config('guinux.phone')) }}">{{ config('guinux.phone') }}</a></span>
        </div>
    </div>
</div>

<header class="header">
    <div class="container">
        <a href="{{ route('home') }}" class="brand" aria-label="Guinux Connect – accueil">
            <img src="{{ asset('images/logo-icon.png') }}" alt="">
            <span class="brand__text">GUIN<b>UX</b><small>CONNECT</small></span>
        </a>
        <button class="nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false" data-nav-toggle>
            @include('partials.icon', ['name' => 'menu'])
        </button>
        <nav class="nav" data-nav>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
            <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Boutique</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ route('contact') }}?sujet=devis" class="btn btn--primary btn--sm">Demander un devis</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div>
                <a href="{{ route('home') }}" class="brand">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="" class="brand-logo">
                    <span class="brand__text">GUIN<b>UX</b><small>CONNECT</small></span>
                </a>
                <p class="footer__about">Votre partenaire pour la vente, l'installation et le dépannage de réseaux hotspot WiFi en Guinée.</p>
            </div>
            <div>
                <h4>Navigation</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('services') }}">Nos services</a></li>
                    <li><a href="{{ route('shop.index') }}">Boutique</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('services') }}#vente">Vente de matériel</a></li>
                    <li><a href="{{ route('services') }}#installation">Installation hotspot</a></li>
                    <li><a href="{{ route('services') }}#depannage">Dépannage</a></li>
                    <li><a href="{{ route('services') }}#configuration">Configuration</a></li>
                </ul>
            </div>
            <div>
                <h4>Nous joindre</h4>
                <ul>
                    <li>{{ config('guinux.address') }}</li>
                    <li><a href="tel:{{ preg_replace('/\s+/', '', config('guinux.phone')) }}">{{ config('guinux.phone') }}</a></li>
                    <li><a href="mailto:{{ config('guinux.email') }}">{{ config('guinux.email') }}</a></li>
                    <li><a href="https://wa.me/{{ $wa }}?text={{ $waText }}" target="_blank" rel="noopener">WhatsApp</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <span>© {{ date('Y') }} Guinux Connect. Tous droits réservés.</span>
            <span>Hotspot · WiFi · Réseaux</span>
        </div>
    </div>
</footer>

<a class="wa-float" href="https://wa.me/{{ $wa }}?text={{ $waText }}" target="_blank" rel="noopener" aria-label="Discuter sur WhatsApp">
    @include('partials.icon', ['name' => 'whatsapp'])
</a>

<script src="{{ asset('js/site.js') }}?v=1" defer></script>
</body>
</html>
