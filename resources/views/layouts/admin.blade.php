<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Administration') · Guinux Connect</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body>
<div class="mobile-bar">
    <button data-aside-toggle aria-label="Menu">@include('partials.icon', ['name' => 'menu'])</button>
    <strong>Guinux Connect</strong>
    <span></span>
</div>
<div class="admin">
    <aside class="aside" data-aside>
        <a href="{{ route('admin.dashboard') }}" class="aside__brand">
            <img src="{{ asset('images/logo-icon.png') }}" alt="">
            <div><strong>GUINUX</strong><small>ADMIN</small></div>
        </a>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">@include('partials.icon', ['name' => 'grid']) Tableau de bord</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">@include('partials.icon', ['name' => 'box']) Produits</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">@include('partials.icon', ['name' => 'tag']) Catégories</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">@include('partials.icon', ['name' => 'message']) Messages
                @if($unreadCount)<span class="badge badge--count">{{ $unreadCount }}</span>@endif
            </a>
        </nav>
        <div class="aside__bottom">
            <a href="{{ route('home') }}" target="_blank">@include('partials.icon', ['name' => 'external']) Voir le site</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">@include('partials.icon', ['name' => 'logout']) Déconnexion</button>
            </form>
        </div>
    </aside>

    <main class="main">
        @if(session('success'))
            <div class="alert alert--success">@include('partials.icon', ['name' => 'check']) {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert--error">@include('partials.icon', ['name' => 'alert']) Merci de corriger les erreurs ci-dessous.</div>
        @endif
        @yield('content')
    </main>
</div>

{{-- Fenêtre de confirmation de suppression --}}
<div class="modal-backdrop" data-modal>
    <div class="modal" role="dialog" aria-modal="true">
        <h3>Confirmer la suppression</h3>
        <p data-modal-text>Cette action est définitive.</p>
        <div class="btns">
            <button class="btn btn--outline" data-modal-cancel>Annuler</button>
            <button class="btn btn--danger" data-modal-confirm>@include('partials.icon', ['name' => 'trash']) Supprimer</button>
        </div>
    </div>
</div>

<script>
(function () {
    var t = document.querySelector('[data-aside-toggle]'), a = document.querySelector('[data-aside]');
    if (t) t.addEventListener('click', function (e) { e.stopPropagation(); a.classList.toggle('open'); });
    document.addEventListener('click', function (e) { if (a.classList.contains('open') && !a.contains(e.target)) a.classList.remove('open'); });

    // Confirmation avant suppression
    var modal = document.querySelector('[data-modal]'), pending = null;
    document.querySelectorAll('form[data-confirm]').forEach(function (f) {
        f.addEventListener('submit', function (e) {
            if (f.dataset.confirmed) return;
            e.preventDefault(); pending = f;
            modal.querySelector('[data-modal-text]').textContent = f.dataset.confirm;
            modal.classList.add('open');
        });
    });
    modal.querySelector('[data-modal-cancel]').onclick = function () { modal.classList.remove('open'); pending = null; };
    modal.querySelector('[data-modal-confirm]').onclick = function () { if (pending) { pending.dataset.confirmed = 1; pending.submit(); } };
    modal.addEventListener('click', function (e) { if (e.target === modal) modal.classList.remove('open'); });
})();
</script>
@stack('scripts')
</body>
</html>
