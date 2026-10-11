@extends('layouts.app')
@section('title', 'Nos services')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb"><a href="{{ route('home') }}">Accueil</a> / Services</div>
        <h1>Nos services</h1>
        <p>De la vente du matériel à la maintenance, nous accompagnons particuliers, commerces, hôtels, écoles et opérateurs de quartier.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="services-grid" style="grid-template-columns:repeat(auto-fit,minmax(260px,1fr))">
            <div class="service reveal" id="vente">
                <div class="service__icon">@include('partials.icon', ['name' => 'router'])</div>
                <h3>Vente de matériel hotspot</h3>
                <p>Un stock d'équipements fiables, conseillés selon votre besoin réel.</p>
                <ul>
                    <li>Routeurs et contrôleurs hotspot</li>
                    <li>Points d'accès intérieurs et extérieurs</li>
                    <li>Antennes, liaisons longue distance</li>
                    <li>Câbles, switch PoE, onduleurs</li>
                </ul>
            </div>
            <div class="service reveal" id="installation">
                <div class="service__icon">@include('partials.icon', ['name' => 'wifi'])</div>
                <h3>Installation de sites hotspot</h3>
                <p>Un réseau bien conçu dès le départ, c'est moins de pannes ensuite.</p>
                <ul>
                    <li>Étude de couverture sur site</li>
                    <li>Pose sur pylône, toit ou en intérieur</li>
                    <li>Câblage propre et sécurisé</li>
                    <li>Mise en service et formation</li>
                </ul>
            </div>
            <div class="service reveal" id="depannage">
                <div class="service__icon">@include('partials.icon', ['name' => 'tool'])</div>
                <h3>Dépannage & maintenance</h3>
                <p>Votre réseau est votre revenu : on le remet en ligne vite.</p>
                <ul>
                    <li>Diagnostic à distance ou sur place</li>
                    <li>Remplacement de matériel défectueux</li>
                    <li>Optimisation du signal et du débit</li>
                    <li>Contrats de maintenance mensuels</li>
                </ul>
            </div>
            <div class="service reveal" id="configuration">
                <div class="service__icon">@include('partials.icon', ['name' => 'settings'])</div>
                <h3>Configuration & gestion</h3>
                <p>Un hotspot simple à exploiter au quotidien.</p>
                <ul>
                    <li>Paramétrage MikroTik / portail captif</li>
                    <li>Création et impression de tickets</li>
                    <li>Gestion des forfaits et utilisateurs</li>
                    <li>Sécurisation du réseau</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow">Pour qui ?</span>
            <h2>Des solutions adaptées à chaque lieu</h2>
        </div>
        <div class="steps" style="counter-reset:none">
            @foreach([['Quartiers & opérateurs', 'Vendez l\'accès internet par tickets à votre voisinage.'], ['Hôtels & restaurants', 'Offrez un WiFi fiable et contrôlé à vos clients.'], ['Écoles & bureaux', 'Partagez la connexion en toute sécurité.'], ['Commerces & marchés', 'Attirez la clientèle avec un WiFi gratuit ou payant.']] as [$t, $d])
                <div class="service reveal"><div class="service__icon">@include('partials.icon', ['name' => 'check'])</div><h3>{{ $t }}</h3><p>{{ $d }}</p></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta reveal">
            <div>
                <h2>Parlons de votre projet</h2>
                <p>Devis gratuit, conseil personnalisé, réponse rapide.</p>
            </div>
            <div class="btns">
                <a href="{{ route('contact') }}?sujet=devis" class="btn btn--white">Demander un devis</a>
                <a href="{{ route('shop.index') }}" class="btn btn--ghost">Voir le matériel</a>
            </div>
        </div>
    </div>
</section>
@endsection
