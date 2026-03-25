<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER – Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            height: 100%;
            min-height: 100vh;
        }

        .bg-burger {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .bg-burger img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1;
        }

        .page-content {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 2rem 5%;
        }

        .brand-text {
            position: fixed;
            bottom: 2.5rem;
            left: 3rem;
            z-index: 3;
            color: white;
        }

        .brand-text h1 {
            font-size: 3rem;
            font-weight: 900;
            letter-spacing: 2px;
            text-shadow: 0 2px 12px rgba(0,0,0,0.6);
            line-height: 1;
        }

        .brand-text p {
            font-size: 1rem;
            opacity: 0.8;
            margin-top: 0.4rem;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 16px 60px rgba(0, 0, 0, 0.35);
        }

        .login-card h2 {
            font-size: 1.9rem;
            font-weight: 800;
            color: white;
        }

        .login-card .subtitle {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.92rem;
            margin-bottom: 1.8rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.90);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.65rem 1rem;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            border-color: #ff6b00;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 0, 0.25);
            background: rgba(255, 255, 255, 0.20);
            color: white;
        }

        .btn-orange {
            background-color: #ff6b00;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 1rem;
            transition: background 0.2s, transform 0.1s;
            width: 100%;
        }

        .btn-orange:hover {
            background-color: #e05a00;
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

{{-- Image de fond --}}
<div class="bg-burger">
    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1600&auto=format&fit=crop"
         alt="ISI Burger">
</div>

{{-- Overlay --}}
<div class="bg-overlay"></div>

{{-- Nom du restaurant --}}
<div class="brand-text">
    <h1>ISI BURGER</h1>
    <p>Le meilleur burger de Dakar — Commandez en ligne</p>
</div>

{{-- Formulaire inscription --}}
<div class="page-content">
    <div class="login-card">

        <h2>Inscription</h2>
        <p class="subtitle">Créez votre compte client</p>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 py-2 mb-3" style="font-size:0.88rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom complet</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Votre nom" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}"
                       placeholder="exemple@email.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-orange">
                Créer mon compte →
            </button>
        </form>

        <div class="mt-4 text-center">
            <p style="color: rgba(255,255,255,0.75); font-size: 0.90rem; margin: 0;">
                Déjà un compte ?
                <a href="{{ route('login') }}"
                   style="color: #ff6b00; font-weight: 700; text-decoration: none;">
                    Se connecter
                </a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
