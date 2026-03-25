@extends('layouts.gestionnaire')

@section('page-title', 'Burgers')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Gestion des Burgers</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                {{ $burgers->count() }} burger(s) au total
            </p>
        </div>
        <a href="{{ route('gestionnaire.burgers.create') }}" class="btn btn-warning fw-bold">
            <i class="bi bi-plus-lg"></i> Ajouter un burger
        </a>
    </div>

    <div class="table-card">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($burgers as $burger)
                <tr>
                    <td>
                        @if($burger->image)
                            <img src="{{ asset('storage/' . $burger->image) }}"
                                 style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:50px; height:50px; background:#f0f0f0;
                                    border-radius:8px; display:flex; align-items:center;
                                    justify-content:center; font-size:1.5rem;">
                                🍔
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $burger->nom }}</strong></td>
                    <td>{{ $burger->categorie->nom }}</td>
                    <td class="fw-bold text-warning">
                        {{ number_format($burger->prix, 0, ',', ' ') }} F
                    </td>
                    <td>
                        @if($burger->stock <= 0)
                            <span class="badge bg-danger">Rupture</span>
                        @elseif($burger->stock <= 5)
                            <span class="badge bg-warning text-dark">{{ $burger->stock }}</span>
                        @else
                            <span class="badge bg-success">{{ $burger->stock }}</span>
                        @endif
                    </td>
                    <td>
                        @if($burger->actif)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Archivé</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('gestionnaire.burgers.edit', $burger) }}"
                           class="btn btn-sm btn-outline-primary rounded-pill me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('gestionnaire.burgers.destroy', $burger) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Archiver ce burger ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-archive"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        Aucun burger trouvé.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
