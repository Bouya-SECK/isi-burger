@extends('layouts.client')

@section('content')

    <div class="mb-4">
        <a href="{{ route('client.commandes.index') }}"
           class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row g-4">

        {{-- Détail commande --}}
        <div class="col-md-8">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Commande #{{ $commande->id }}</h5>
                    <span class="badge-statut badge-{{ $commande->statut }}">
                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                </span>
                </div>

                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Burger</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($commande->items as $item)
                        <tr>
                            <td>{{ $item->burger->nom }}</td>
                            <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
                            <td>x{{ $item->quantite }}</td>
                            <td class="fw-bold">
                                {{ number_format($item->quantite * $item->prix_unitaire, 0, ',', ' ') }} F
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="fw-bold text-end">Total :</td>
                        <td class="fw-bold text-warning fs-5">
                            {{ number_format($commande->total, 0, ',', ' ') }} F
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Infos paiement --}}
        <div class="col-md-4">
            <div class="table-card">
                <h6 class="fw-bold mb-3">Informations</h6>

                <div class="mb-2">
                    <small class="text-muted">Date de commande</small>
                    <div class="fw-semibold">
                        {{ $commande->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Statut</small>
                    <div>
                    <span class="badge-statut badge-{{ $commande->statut }}">
                        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                    </span>
                    </div>
                </div>

                @if($commande->paiement)
                    <div class="mb-2">
                        <small class="text-muted">Paiement</small>
                        <div class="fw-semibold text-success">
                            <i class="bi bi-check-circle"></i>
                            {{ number_format($commande->paiement->montant, 0, ',', ' ') }} F
                        </div>
                    </div>
                @endif

                @if($commande->statut === 'prete')
                    <div class="alert alert-success mt-3 rounded-3" style="font-size:0.88rem;">
                        <i class="bi bi-check-circle"></i>
                        Votre commande est prête ! Venez la récupérer.
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
