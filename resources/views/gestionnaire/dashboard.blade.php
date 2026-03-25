@extends('layouts.gestionnaire')

@section('page-title', 'Dashboard')

@section('content')

    {{-- ── Cartes statistiques ── --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="stat-card position-relative">
                <div class="stat-label">Commandes en cours</div>
                <div class="stat-value">{{ $commandesEnCours }}</div>
                <i class="bi bi-clock-history stat-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card green position-relative">
                <div class="stat-label">Commandes validées</div>
                <div class="stat-value">{{ $commandesValidees }}</div>
                <i class="bi bi-check-circle stat-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card blue position-relative">
                <div class="stat-label">Recettes du jour</div>
                <div class="stat-value">{{ number_format($recetteJour, 0, ',', ' ') }} F</div>
                <i class="bi bi-cash-stack stat-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card red position-relative">
                <div class="stat-label">Burgers au catalogue</div>
                <div class="stat-value">{{ $totalBurgers }}</div>
                <i class="bi bi-egg-fried stat-icon"></i>
            </div>
        </div>

    </div>

    {{-- ── Dernières commandes ── --}}
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="table-title">Dernières commandes</div>
            <a href="{{ route('gestionnaire.commandes.index') }}"
               class="btn btn-sm btn-outline-secondary rounded-pill">
                Voir tout <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dernieresCommandes as $commande)
                <tr>
                    <td><strong>#{{ $commande->id }}</strong></td>
                    <td>{{ $commande->user->name }}</td>
                    <td>{{ number_format($commande->total, 0, ',', ' ') }} F</td>
                    <td>
                    <span class="badge-statut badge-{{ $commande->statut }}">
                        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                    </span>
                    </td>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('gestionnaire.commandes.show', $commande) }}"
                           class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucune commande pour le moment
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
