@extends('layouts.app')
@section('title', 'Contact')

@section('content')
@php
    $defaultSubject = $product ? 'Devis : '.$product->name : (request('sujet') === 'devis' ? 'Demande de devis' : '');
@endphp
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb"><a href="{{ route('home') }}">Accueil</a> / Contact</div>
        <h1>Contactez-nous</h1>
        <p>Une question, un devis ou une panne ? Écrivez-nous, nous répondons rapidement.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <div class="info-card">
            <h3>Guinux Connect</h3>
            <p>Vente, installation et dépannage de matériel hotspot WiFi.</p>
            <div class="info-item">@include('partials.icon', ['name' => 'phone'])<div><small>Téléphone</small><a href="tel:{{ preg_replace('/\s+/', '', config('guinux.phone')) }}">{{ config('guinux.phone') }}</a></div></div>
            <div class="info-item">@include('partials.icon', ['name' => 'whatsapp'])<div><small>WhatsApp</small><a href="https://wa.me/{{ config('guinux.whatsapp') }}" target="_blank" rel="noopener">Discuter maintenant</a></div></div>
            <div class="info-item">@include('partials.icon', ['name' => 'mail'])<div><small>E-mail</small><a href="mailto:{{ config('guinux.email') }}">{{ config('guinux.email') }}</a></div></div>
            <div class="info-item">@include('partials.icon', ['name' => 'map'])<div><small>Adresse</small><span>{{ config('guinux.address') }}</span></div></div>
            <div class="info-item">@include('partials.icon', ['name' => 'clock'])<div><small>Horaires</small><span>Lun – Sam : 8h – 19h</span></div></div>
        </div>

        <div class="form-card">
            @if(session('success'))
                <div class="alert alert--success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert--error">Merci de corriger les champs indiqués.</div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                @if($product)<input type="hidden" name="product_id" value="{{ $product->id }}">@endif
                <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">

                <div class="field">
                    <label for="name">Nom complet *</label>
                    <input class="input" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="phone">Téléphone</label>
                        <input class="input" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+224 …">
                        @error('phone')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label for="email">E-mail</label>
                        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}">
                        @error('email')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="field">
                    <label for="subject">Sujet</label>
                    <select class="input" id="subject" name="subject">
                        @foreach(array_filter(array_unique([$defaultSubject, 'Demande de devis', 'Achat de matériel', 'Installation hotspot', 'Dépannage / panne', 'Autre'])) as $s)
                            <option @selected(old('subject', $defaultSubject) === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="body">Votre message *</label>
                    <textarea class="input" id="body" name="body" rows="6" required placeholder="Décrivez votre besoin : lieu, surface à couvrir, nombre d'utilisateurs, panne constatée…">{{ old('body') }}</textarea>
                    @error('body')<div class="error">{{ $message }}</div>@enderror
                </div>
                <button class="btn btn--primary btn--block" type="submit">Envoyer le message @include('partials.icon', ['name' => 'arrow'])</button>
            </form>
        </div>
    </div>
</section>
@endsection
