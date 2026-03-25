<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ── Navbar ── */
        .navbar-isi {
            background: #1a1a1a;
            padding: 0.8rem 2rem;
        }

        .navbar-isi .navbar-brand {
            color: #ff6b00 !important;
            font-weight: 900;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }

        .navbar-isi .nav-link {
            color: rgba(255,255,255,0.7) !important;
            font-size: 0.92rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .navbar-isi .nav-link:hover,
        .navbar-isi .nav-link.active {
            color: white !important;
            background: rgba(255,107,0,0.15);
        }

        .navbar-isi .nav-link i {
            margin-right: 5px;
        }

        .btn-logout {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7) !important;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 0.4rem 1rem !important;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: rgba(220,53,69,0.2);
            color: #ff6b6b !important;
            border-color: rgba(220,53,69,0.3);
        }

        /* ── Page body ── */
        .page-body {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ── Cards burger ── */
        .burger-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .burger-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .burger-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .burger-card .card-body {
            padding: 1.2rem;
        }

        .burger-card .burger-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.3rem;
        }

        .burger-card .burger-desc {
            font-size: 0.83rem;
            color: #888;
            margin-bottom: 0.8rem;
            line-height: 1.5;
        }

        .burger-card .burger-prix {
            font-size: 1.2rem;
            font-weight: 800;
            color: #ff6b00;
        }

        .btn-orange {
            background-color: #ff6b00;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.88rem;
            transition: background 0.2s;
            cursor: pointer;
        }

        .btn-orange:hover {
            background-color: #e05a00;
            color: white;
        }

        .badge-rupture {
            background: #f8d7da;
            color: #721c24;
            font-size: 0.75rem;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── Table commandes ── */
        .table-card {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .table thead th {
            font-size: 0.80rem;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
            padding: 0.6rem 0.8rem;
        }

        .table tbody td {
            font-size: 0.90rem;
            padding: 0.75rem 0.8rem;
            vertical-align: middle;
            border-color: #f5f5f5;
        }

        /* ── Badges statut ── */
        .badge-statut {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-en_attente     { background: #fff3cd; color: #856404; }
        .badge-en_preparation { background: #cfe2ff; color: #084298; }
        .badge-prete          { background: #d1e7dd; color: #0a3622; }
        .badge-payee          { background: #d4edda; color: #155724; }
        .badge-annulee        { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

{{-- ── Navbar ── --}}
<nav class="navbar navbar-expand-lg navbar-isi">
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ route('client.catalogue') }}">
            🍔 ISI BURGER
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.catalogue') ? 'active' : '' }}"
                       href="{{ route('client.catalogue') }}">
                        <i class="bi bi-grid"></i> Catalogue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.commandes.*') ? 'active' : '' }}"
                       href="{{ route('client.commandes.index') }}">
                        <i class="bi bi-bag"></i> Mes commandes
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <span style="color:rgba(255,255,255,0.5); font-size:0.88rem;">
                        👤 {{ auth()->user()->name }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>

{{-- ── Contenu des pages ── --}}
<div class="page-body">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
