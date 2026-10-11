@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
<div class="topline">
    <div>
        <h1>Bonjour {{ auth()->user()->name }} 👋</h1>
        <p>Voici l'état de votre boutique aujourd'hui.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn--primary">@include('partials.icon', ['name' => 'plus']) Ajouter un produit</a>
</div>

<div class="kpis">
    <div class="kpi"><div class="kpi__icon">@include('partials.icon', ['name' => 'box'])</div><div><strong>{{ $stats['products'] }}</strong><span>Produits ({{ $stats['active'] }} en ligne)</span></div></div>
    <div class="kpi"><div class="kpi__icon" style="background:#fff4e0;color:#e08a00">@include('partials.icon', ['name' => 'alert'])</div><div><strong>{{ $stats['out_of_stock'] }}</strong><span>En rupture de stock</span></div></div>
    <div class="kpi"><div class="kpi__icon">@include('partials.icon', ['name' => 'tag'])</div><div><strong>{{ $stats['categories'] }}</strong><span>Catégories</span></div></div>
    <div class="kpi"><div class="kpi__icon" style="background:#fdecec;color:#d93a3a">@include('partials.icon', ['name' => 'message'])</div><div><strong>{{ $stats['unread'] }}</strong><span>Messages non lus</span></div></div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card__head"><h2>Derniers produits</h2><a href="{{ route('admin.products.index') }}">Tout voir</a></div>
        @forelse($latestProducts as $p)
            <a href="{{ route('admin.products.edit', $p) }}" class="list-item">
                <span class="prod-cell"><img class="thumb" src="{{ $p->image_url }}" alt=""><span><strong>{{ $p->name }}</strong><small>{{ $p->category?->name ?? 'Sans catégorie' }}</small></span></span>
                <span style="text-align:right"><strong>{{ $p->formatted_price }}</strong><br><small>Stock : {{ $p->stock }}</small></span>
            </a>
        @empty
            <div class="empty">Aucun produit pour le moment.</div>
        @endforelse
    </div>
    <div class="card">
        <div class="card__head"><h2>Derniers messages</h2><a href="{{ route('admin.messages.index') }}">Tout voir</a></div>
        @forelse($latestMessages as $m)
            <a href="{{ route('admin.messages.show', $m) }}" class="list-item">
                <span><strong>{{ $m->name }}</strong> @unless($m->read_at)<span class="badge badge--blue">Nouveau</span>@endunless<br><small>{{ $m->subject ?: \Illuminate\Support\Str::limit($m->body, 50) }}</small></span>
                <small>{{ $m->created_at->diffForHumans() }}</small>
            </a>
        @empty
            <div class="empty">Aucun message reçu.</div>
        @endforelse
    </div>
</div>
@endsection
