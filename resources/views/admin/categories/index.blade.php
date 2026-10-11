@extends('layouts.admin')
@section('title', 'Catégories')

@section('content')
<div class="topline">
    <div><h1>Catégories</h1><p>Organisez les produits de la boutique.</p></div>
</div>

<div class="form-grid">
    <div class="card">
        @if($categories->isEmpty())
            <div class="empty">@include('partials.icon', ['name' => 'tag'])<p>Aucune catégorie. Créez-en une à droite.</p></div>
        @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nom</th><th>Produits</th><th style="text-align:right">Actions</th></tr></thead>
                <tbody>
                @foreach($categories as $c)
                    <tr>
                        <td>
                            <form method="POST" action="{{ route('admin.categories.update', $c) }}" style="display:flex;gap:8px;margin:0">
                                @csrf @method('PUT')
                                <input class="input" name="name" value="{{ $c->name }}" required style="max-width:320px">
                                <button class="icon-btn" title="Renommer">@include('partials.icon', ['name' => 'check'])</button>
                            </form>
                        </td>
                        <td><a href="{{ route('admin.products.index', ['category' => $c->id]) }}" class="badge badge--blue">{{ $c->products_count }}</a></td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" data-confirm="Supprimer la catégorie « {{ $c->name }} » ? Ses {{ $c->products_count }} produit(s) seront conservés sans catégorie.">
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
        @endif
    </div>

    <div class="card">
        <div class="card__head"><h2>Nouvelle catégorie</h2></div>
        <div class="card__body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="field">
                    <label for="name">Nom</label>
                    <input class="input" id="name" name="name" value="{{ old('name') }}" required maxlength="100" placeholder="Ex. Antennes">
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>
                <button class="btn btn--primary" type="submit">@include('partials.icon', ['name' => 'plus']) Ajouter</button>
            </form>
        </div>
    </div>
</div>
@endsection
