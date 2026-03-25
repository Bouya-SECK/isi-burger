@extends('layouts.gestionnaire')

@section('page-title', 'Détail Commande')

@section('content')

    <div class="mb-4">
        <a href="{{ route('gestionnaire.commandes.index') }}"
           class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row g-4">

        {{-- Détail items --}}
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

        {{-- Actions --}}
        <div class="col-md-4">

            {{-- Infos client --}}
            <div class="table-card mb-3">
                <h6 class="fw-bold mb-3">Client</h6>
                <p class="mb-1">
                    <i class="bi bi-person"></i>
                    {{ $commande->user->name }}
                </p>
                <p class="mb-0 text-muted" style="font-size:0.88rem;">
                    <i class="bi bi-envelope"></i>
                    {{ $commande->user->email }}
                </p>
                <hr>
                <small class="text-muted">Commandé le</small>
                <div class="fw-semibold">
                    {{ $commande->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>

            {{-- Changer statut --}}
            @if(!in_array($commande->statut, ['payee', 'annulee']))
                <div class="table-card mb-3">
                    <h6 class="fw-bold mb-3">Changer le statut</h6>
                    <form method="POST"
                          action="{{ route('gestionnaire.commandes.statut', $commande) }}">
                        @csrf
                        @method('PATCH')
                        <select name="statut" class="form-select mb-2">
                            <option value="en_attente"
                                {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>
                                En attente
                            </option>
                            <option value="en_preparation"
                                {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>
                                En préparation
                            </option>
                            <option value="prete"
                                {{ $commande->statut == 'prete' ? 'selected' : '' }}>
                                Prête
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-check-lg"></i> Mettre à jour
                        </button>
                    </form>
                </div>
            @endif

            {{-- Paiement --}}
            @if($commande->statut === 'prete' && !$commande->paiement)
                <div class="table-card mb-3">
                    <h6 class="fw-bold mb-3">Enregistrer le paiement</h6>
                    <form method="POST"
                          action="{{ route('gestionnaire.paiements.store', $commande) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Montant (F CFA)</label>
                            <input type="number" name="montant" class="form-control"
                                   value="{{ $commande->total }}" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="bi bi-cash"></i> Confirmer le paiement
                        </button>
                    </form>
                </div>
            @endif

            @if($commande->paiement)
                <div class="table-card mb-3">
                    <h6 class="fw-bold mb-2 text-success">
                        <i class="bi bi-check-circle"></i> Paiement reçu
                    </h6>
                    <p class="mb-1">
                        Montant :
                        <strong>{{ number_format($commande->paiement->montant, 0, ',', ' ') }} F</strong>
                    </p>
                    <p class="mb-0 text-muted" style="font-size:0.85rem;">
                        {{ \Carbon\Carbon::parse($commande->paiement->paye_le)->format('d/m/Y à H:i') }}
                    </p>
                </div>
            @endif

            {{-- Annuler --}}
            @if(!in_array($commande->statut, ['payee', 'annulee']))
                <form method="POST"
                      action="{{ route('gestionnaire.commandes.annuler', $commande) }}"
                      onsubmit="return confirm('Annuler cette commande ?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger w-100 fw-bold">
                        <i class="bi bi-x-circle"></i> Annuler la commande
                    </button>
                </form>
            @endif

        </div>
    </div>

@endsection
