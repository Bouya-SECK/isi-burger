@extends('layouts.client')

@section('content')
    {{-- Titre catalogue --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Notre Catalogue</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Choisissez vos burgers préférés
            </p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-3 p-3 mb-4 shadow-sm d-flex gap-3 flex-wrap align-items-center">
        <form method="GET" action="{{ route('client.catalogue') }}" class="d-flex gap-2 flex-wrap w-100">
            <input type="text" name="search" class="form-control" style="max-width:220px;"
                   placeholder=" Rechercher..." value="{{ request('search') }}">

            <select name="categorie" class="form-select" style="max-width:180px;">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom }}
                    </option>
                @endforeach
            </select>

            <select name="tri" class="form-select" style="max-width:180px;">
                <option value="">Trier par prix</option>
                <option value="asc"  {{ request('tri') == 'asc'  ? 'selected' : '' }}>Prix croissant</option>
                <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>

            <button type="submit" class="btn-orange btn">Filtrer</button>
            <a href="{{ route('client.catalogue') }}" class="btn btn-outline-secondary">Reset</a>
        </form>
    </div>

    {{-- Catalogue des burgers --}}
    <div class="row g-4">
        @forelse($burgers as $burger)
            <div class="col-md-4 col-sm-6">
                <div class="burger-card">

                    {{-- Image --}}
                    @php
                        $images = [
                            'ISI Classic' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&auto=format&fit=crop',
                            'ISI Spicy'   => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=600&auto=format&fit=crop',
                            'ISI Veggie'  => 'https://images.unsplash.com/photo-1520072959219-c595dc870360?w=600&auto=format&fit=crop',
                        ];
                        $defaultImage = 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=600&auto=format&fit=crop';
                    @endphp

                    @if($burger->image)
                        <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}">
                    @else
                        <img src="{{ $images[$burger->nom] ?? $defaultImage }}" alt="{{ $burger->nom }}">
                    @endif

                    <div class="card-body">
                        <div class="burger-name">{{ $burger->nom }}</div>
                        <div class="burger-desc">{{ $burger->description }}</div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="burger-prix">{{ number_format($burger->prix, 0, ',', ' ') }} F</span>
                            {{--
                                  Si la stock est 0 : on affiche rupture de stock
                                  et on masque la bouton commander et Sinon on affiche
                                  la Bouton Commander
                            --}}
                            @if($burger->stock <= 0)
                                <span class="badge-rupture">Rupture de stock</span>
                            @else
                                <button class="btn-orange btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalCommander"
                                        data-id="{{ $burger->id }}"
                                        data-nom="{{ $burger->nom }}"
                                        data-prix="{{ $burger->prix }}">
                                    <i class="bi bi-cart-plus"></i> Commander
                                </button>
                            @endif
                        </div>

                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-tag"></i> {{ $burger->categorie->nom }}
                                &nbsp;|&nbsp;
                                <i class="bi bi-box"></i> Stock : {{ $burger->stock }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <div style="font-size:3rem;">🍔</div>
                <p>Aucun burger disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal Commander --}}
    <div class="modal fade" id="modalCommander" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Commander</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('client.commandes.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="burger_id" id="modal_burger_id">

                        <p class="text-muted mb-3">
                            Burger : <strong id="modal_burger_nom"></strong>
                        </p>

                        <label class="form-label fw-semibold">Quantité</label>
                        <input type="number" name="quantite" class="form-control"
                               value="1" min="1" max="10" required>

                        <div class="mt-3 p-3 bg-light rounded-3">
                            <small class="text-muted">Prix unitaire :</small>
                            <div class="fw-bold text-warning" id="modal_prix"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-orange btn px-4">
                            <i class="bi bi-check-lg"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Remplir le modal avec les infos du burger
        document.getElementById('modalCommander').addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            document.getElementById('modal_burger_id').value  = btn.dataset.id;
            document.getElementById('modal_burger_nom').textContent = btn.dataset.nom;
            document.getElementById('modal_prix').textContent =
                parseInt(btn.dataset.prix).toLocaleString() + ' F CFA';
        });
    </script>
@endsection
