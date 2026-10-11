@extends('layouts.admin')
@section('title', 'Message de '.$message->name)

@section('content')
@php
    $waNumber = $message->phone ? preg_replace('/\D+/', '', $message->phone) : null;
@endphp
<div class="topline">
    <div><h1>{{ $message->subject ?: 'Message' }}</h1><p><a href="{{ route('admin.messages.index') }}">← Tous les messages</a></p></div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        @if($waNumber)<a class="btn btn--outline" target="_blank" rel="noopener" href="https://wa.me/{{ $waNumber }}">@include('partials.icon', ['name' => 'whatsapp']) Répondre sur WhatsApp</a>@endif
        @if($message->email)<a class="btn btn--primary" href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Votre message')) }}">@include('partials.icon', ['name' => 'mail']) Répondre par e-mail</a>@endif
    </div>
</div>

<div class="form-grid">
    <div class="card"><div class="card__body" style="white-space:pre-line;font-size:16px">{{ $message->body }}</div></div>
    <div class="card">
        <div class="card__head"><h2>Expéditeur</h2></div>
        <div class="card__body">
            <p><strong>{{ $message->name }}</strong></p>
            @if($message->phone)<p>@include('partials.icon', ['name' => 'phone']) <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a></p>@endif
            @if($message->email)<p>@include('partials.icon', ['name' => 'mail']) <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>@endif
            <p style="color:var(--muted)">Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}</p>
            @if($message->product)
                <p>Produit concerné :<br><a href="{{ route('admin.products.edit', $message->product) }}">{{ $message->product->name }}</a></p>
            @endif
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" data-confirm="Supprimer ce message ?">
                @csrf @method('DELETE')
                <button class="btn btn--danger btn--sm">@include('partials.icon', ['name' => 'trash']) Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection
