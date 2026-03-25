@extends('layouts.client')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"> Mes Commandes</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Suivez vos commandes en temps réel
            </p>
        </div>
        <a href="{{ route('client.catalogue') }}" class="btn-orange btn">
            <i class="bi bi-plus-lg"></i> Nouvelle commande
        </a>
    </div>

    <div class="table-card">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Burgers</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($commandes as $commande)
                <tr>
                    <td><strong>#{{ $commande->id }}</strong></td>
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
                        <a href="{{ route('client.commandes.show', $commande) }}"
                           class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-eye"></i> Détail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div style="font-size:3rem;"></div>
                        <p>Vous n'avez pas encore de commande.</p>
                        <a href="{{ route('client.catalogue') }}" class="btn-orange btn">
                            Commander maintenant
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
