@extends('layouts.admin')
@section('title', $product->exists ? 'Modifier un produit' : 'Nouveau produit')

@section('content')
<div class="topline">
    <div>
        <h1>{{ $product->exists ? 'Modifier le produit' : 'Nouveau produit' }}</h1>
        <p><a href="{{ route('admin.products.index') }}">← Retour à la liste</a></p>
    </div>
    @if($product->exists && $product->is_active)
        <a href="{{ route('shop.show', $product) }}" target="_blank" class="btn btn--outline">@include('partials.icon', ['name' => 'external']) Voir sur le site</a>
    @endif
</div>

<form method="POST" enctype="multipart/form-data"
      action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if($product->exists) @method('PUT') @endif

    <div class="form-grid">
        <div class="card"><div class="card__body">
            <div class="field">
                <label for="name">Nom du produit *</label>
                <input class="input" id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="160" placeholder="Ex. Routeur MikroTik hAP ac²">
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="short_description">Description courte</label>
                <input class="input" id="short_description" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="255" placeholder="Une phrase affichée sur la carte produit">
                @error('short_description')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="description">Description détaillée</label>
                <textarea class="input" id="description" name="description" rows="8" placeholder="Caractéristiques, portée, usage conseillé…">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="row-3">
                <div class="field">
                    <label for="price">Prix (GNF) *</label>
                    <input class="input" id="price" type="number" min="0" step="1" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="old_price">Ancien prix (GNF)</label>
                    <input class="input" id="old_price" type="number" min="0" step="1" name="old_price" value="{{ old('old_price', $product->old_price) }}">
                    <div class="hint">Pour afficher une promo barrée.</div>
                    @error('old_price')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="stock">Stock *</label>
                    <input class="input" id="stock" type="number" min="0" step="1" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="field" style="margin:0">
                <label for="category_id">Catégorie</label>
                <select class="input" id="category_id" name="category_id">
                    <option value="">— Sans catégorie —</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
                <div class="hint">Gérez la liste dans <a href="{{ route('admin.categories.index') }}">Catégories</a>.</div>
                @error('category_id')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div></div>

        <div style="display:grid;gap:20px">
            <div class="card">
                <div class="card__head"><h2>Image</h2></div>
                <div class="card__body">
                    <label class="dropzone" data-dropzone>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" data-image-input>
                        <img @if($product->image) src="{{ $product->image_url }}" @else hidden @endif alt="" data-image-preview>
                        <div data-image-empty @if($product->image) hidden @endif>
                            @include('partials.icon', ['name' => 'plus'])
                            <div>Cliquez ou glissez une image</div>
                            <small>JPG, PNG ou WEBP · 4 Mo max.</small>
                        </div>
                    </label>
                    @error('image')<div class="error" style="color:var(--danger);font-size:13px;margin-top:6px">{{ $message }}</div>@enderror
                    @if($product->image)
                        <label class="switch" style="border:0;padding-bottom:0"><span>Supprimer l'image actuelle</span><input type="checkbox" name="remove_image" value="1"></label>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card__head"><h2>Publication</h2></div>
                <div class="card__body" style="padding-top:6px;padding-bottom:6px">
                    <label class="switch"><span>En ligne<small>Visible dans la boutique</small></span><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))></label>
                    <label class="switch"><span>Mis en avant<small>Affiché en priorité sur l'accueil</small></span><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))></label>
                </div>
            </div>

            <button class="btn btn--primary" type="submit" style="justify-content:center;padding:14px">
                @include('partials.icon', ['name' => 'check']) {{ $product->exists ? 'Enregistrer les modifications' : 'Ajouter le produit' }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    var input = document.querySelector('[data-image-input]'),
        preview = document.querySelector('[data-image-preview]'),
        empty = document.querySelector('[data-image-empty]'),
        zone = document.querySelector('[data-dropzone]');
    input.addEventListener('change', function () {
        var file = input.files[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.hidden = false; empty.hidden = true;
    });
    ['dragenter', 'dragover'].forEach(function (ev) { zone.addEventListener(ev, function () { zone.classList.add('drag'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { zone.addEventListener(ev, function () { zone.classList.remove('drag'); }); });
})();
</script>
@endpush
