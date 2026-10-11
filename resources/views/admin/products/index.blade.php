@extends('layouts.admin')
@section('title', 'Produits')

@section('content')
<div class="topline">
    <div><h1>Produits</h1><p>{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} dans la boutique</p></div>
    <a href="{{ route('admin.products.create') }}" class="btn btn--primary">@include('partials.icon', ['name' => 'plus']) Ajouter un produit</a>
</div>

<div class="card">
    <form class="filters" method="GET">
        <input class="input" type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher par nom…">
        <select class="input" name="category" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <button class="btn btn--outline" type="submit">@include('partials.icon', ['name' => 'search']) Filtrer</button>
        @if(request()->hasAny(['q', 'category']))<a class="btn btn--outline" href="{{ route('admin.products.index') }}">Réinitialiser</a>@endif
    </form>

    @if($products->isEmpty())
        <div class="empty">
            @include('partials.icon', ['name' => 'box'])
            <p>Aucun produit trouvé.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn--primary btn--sm">Ajouter le premier produit</a>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Produit</th><th class="hide-sm">Catégorie</th><th>Prix</th><th>Stock</th><th class="hide-sm">Statut</th><th style="text-align:right">Actions</th></tr>
                </thead>
                <tbody>
                @foreach($products as $p)
                    <tr>
                        <td>
                            <div class="prod-cell">
                                <img class="thumb" src="{{ $p->image_url }}" alt="">
                                <span><strong>{{ $p->name }}</strong>@if($p->is_featured)<small>★ Mis en avant</small>@endif</span>
                            </div>
                        </td>
                        <td class="hide-sm">{{ $p->category?->name ?? '—' }}</td>
                        <td><strong>{{ $p->formatted_price }}</strong>@if($p->discount_percent)<br><small style="color:var(--muted)"><del>{{ $p->formatted_old_price }}</del></small>@endif</td>
                        <td>
                            @if($p->stock === 0)<span class="badge badge--danger">Rupture</span>
                            @elseif($p->stock <= 3)<span class="badge badge--warn">{{ $p->stock }}</span>
                            @else<span class="badge">{{ $p->stock }}</span>@endif
                        </td>
                        <td class="hide-sm">
                            @if($p->is_active)<span class="badge badge--success">En ligne</span>@else<span class="badge">Masqué</span>@endif
                        </td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('admin.products.toggle', $p) }}">
                                    @csrf @method('PATCH')
                                    <button class="icon-btn" title="{{ $p->is_active ? 'Masquer de la boutique' : 'Publier' }}">@include('partials.icon', ['name' => $p->is_active ? 'eye' : 'eye-off'])</button>
                                </form>
                                <a class="icon-btn" href="{{ route('admin.products.edit', $p) }}" title="Modifier">@include('partials.icon', ['name' => 'edit'])</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $p) }}" data-confirm="Supprimer définitivement « {{ $p->name }} » ?">
                                    @csrf @method('DELETE')
                                    <button class="icon-btn icon-btn--danger" title="Supprimer">@include('partials.icon', ['name' => 'trash'])</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    @endif
</div>
@endsection
