<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER – Gestionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: #1a1a1a;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand h4 {
            color: #ff6b00;
            font-weight: 900;
            font-size: 1.3rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
        }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.3);
            font-size: 0.70rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0.8rem 1.2rem 0.3rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.2rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.92rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: white;
            background: rgba(255,107,0,0.12);
            border-left-color: #ff6b00;
        }

        .sidebar-menu a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.88rem;
            transition: color 0.2s;
        }

        .sidebar-footer a:hover {
            color: #ff6b00;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            background: white;
            padding: 0.9rem 2rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar .page-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: #555;
            font-size: 0.90rem;
        }

        .topbar .user-avatar {
            width: 36px;
            height: 36px;
            background: #ff6b00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* ── Page body ── */
        .page-body {
            padding: 2rem;
            flex: 1;
        }

        /* ── Cards stats ── */
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 1.4rem 1.6rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-left: 4px solid #ff6b00;
            height: 100%;
        }

        .stat-card .stat-label {
            font-size: 0.82rem;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.2;
            margin-top: 0.3rem;
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            opacity: 0.15;
            position: absolute;
            right: 1.2rem;
            top: 1.2rem;
        }

        .stat-card.blue  { border-left-color: #0d6efd; }
        .stat-card.green { border-left-color: #198754; }
        .stat-card.red   { border-left-color: #dc3545; }

        /* ── Table ── */
        .table-card {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .table-card .table-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
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

        /* Badges statut */
        .badge-statut {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-en_attente    { background: #fff3cd; color: #856404; }
        .badge-en_preparation { background: #cfe2ff; color: #084298; }
        .badge-prete         { background: #d1e7dd; color: #0a3622; }
        .badge-payee         { background: #d4edda; color: #155724; }
        .badge-annulee       { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

{{-- ── Sidebar ── --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>🍔 ISI BURGER</h4>
        <small>Espace Gestionnaire</small>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Principal</div>
        <a href="{{ route('gestionnaire.dashboard') }}"
           class="{{ request()->routeIs('gestionnaire.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="menu-label">Catalogue</div>
        <a href="{{ route('gestionnaire.burgers.index') }}"
           class="{{ request()->routeIs('gestionnaire.burgers.*') ? 'active' : '' }}">
            <i class="bi bi-egg-fried"></i> Burgers
        </a>

        <div class="menu-label">Ventes</div>
        <a href="{{ route('gestionnaire.commandes.index') }}"
           class="{{ request()->routeIs('gestionnaire.commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Commandes
        </a>

        <div class="menu-label">Rapports</div>
        <a href="{{ route('gestionnaire.stats') }}"
           class="{{ request()->routeIs('gestionnaire.stats') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Statistiques
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
            background: none;
            border: none;
            padding: 0;
            width: 100%;
            text-align: left;
            color: rgba(255,255,255,0.5);
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
        ">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

{{-- ── Main ── --}}
<div class="main-content">

    {{-- Topbar --}}
    <div class="topbar">
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>

    {{-- Contenu des pages --}}
    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
