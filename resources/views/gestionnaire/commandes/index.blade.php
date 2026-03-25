@extends('layouts.gestionnaire')

@section('page-title', 'Commandes')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Gestion des Commandes</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                {{ $commandes->count() }} commande(s) au total
            </p>
        </div>
    </div>

    <div class="table-card">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Burgers</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($commandes as $commande)
                <tr>
                    <td><strong>#{{ $commande->id }}</strong></td>
                    <td>{{ $commande->user->name }}</td>
                    <td>
                        @foreach($commande->items as $item)
                            <span class="badge bg-light text-dark border">
                            {{ $item->burger->nom }} x{{ $item->quantite }}
                        </span>
                        @endforeach
                    </td>
                    <td class="fw-bold text-warning">
                        {{ number_format($commande->total, 0, ',', ' ') }} F
                    </td>
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
                    <td colspan="7" class="text-center py-4 text-muted">
                        Aucune commande pour le moment.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
