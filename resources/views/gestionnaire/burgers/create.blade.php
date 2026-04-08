@extends('layouts.gestionnaire')

@section('page-title', 'Ajouter un burger')

@section('content')

    <div class="mb-4">
        <a href="{{ route('gestionnaire.burgers.index') }}"
           class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="table-card" style="max-width:600px;">
        <h5 class="fw-bold mb-4">Nouveau Burger</h5>

        <form method="POST" action="{{ route('gestionnaire.burgers.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nom du burger</label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom') }}">
                @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Catégorie</label>
                <select name="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
                @error('categorie_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Prix (F CFA)</label>
                    <input type="number" name="prix" class="form-control @error('prix') is-invalid @enderror"
                           value="{{ old('prix') }}" min="0">
                    @error('prix')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stock</label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', 0) }}" min="0">
                    @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="3">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="actif" value="1"
                       class="form-check-input" id="actif" checked>
                <label class="form-check-label" for="actif">Burger actif</label>
            </div>

            <button type="submit" class="btn btn-warning fw-bold px-4">
                <i class="bi bi-check-lg"></i> Enregistrer
            </button>
        </form>

    </div>

@endsection
