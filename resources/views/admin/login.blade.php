<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Connexion · Guinux Connect</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <img src="{{ asset('images/logo.png') }}" alt="Guinux Connect">
        <h1>Espace administrateur</h1>
        <p>Connectez-vous pour gérer la boutique.</p>

        <form method="POST" action="{{ route('admin.login.attempt') }}">
            @csrf
            <div class="field">
                <label for="email">E-mail</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <input class="input" id="password" type="password" name="password" required>
            </div>
            <label class="switch" style="border:0;padding-top:0"><span>Rester connecté</span><input type="checkbox" name="remember" value="1"></label>
            <button class="btn btn--primary" type="submit" style="width:100%;justify-content:center;padding:14px">Se connecter</button>
        </form>
        <p style="margin:20px 0 0;font-size:14px"><a href="{{ route('home') }}">← Retour au site</a></p>
    </div>
</div>
</body>
</html>
