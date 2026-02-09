@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('vehicules.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Modifier le Véhicule : {{ $vehicule->immatriculation }}</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('vehicules.update', $vehicule) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Immatriculation *</label>
                            <input type="text" name="immatriculation" class="form-control @error('immatriculation') is-invalid @enderror" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required>
                            @error('immatriculation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Année</label>
                            <input type="number" name="annee" class="form-control @error('annee') is-invalid @enderror" value="{{ old('annee', $vehicule->annee) }}">
                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Marque *</label>
                            <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror" value="{{ old('marque', $vehicule->marque) }}" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Modèle *</label>
                            <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror" value="{{ old('modele', $vehicule->modele) }}" required>
                            @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Couleur</label>
                            <input type="text" name="couleur" class="form-control" value="{{ old('couleur', $vehicule->couleur) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Énergie</label>
                            <select name="energie" class="form-select">
                                <option value="">Choisir...</option>
                                <option value="Essence" {{ old('energie', $vehicule->energie) == 'Essence' ? 'selected' : '' }}>Essence</option>
                                <option value="Diesel" {{ old('energie', $vehicule->energie) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="Hybride" {{ old('energie', $vehicule->energie) == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                                <option value="Electrique" {{ old('energie', $vehicule->energie) == 'Electrique' ? 'selected' : '' }}>Électrique</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Boîte</label>
                            <select name="boite" class="form-select">
                                <option value="">Choisir...</option>
                                <option value="Manuelle" {{ old('boite', $vehicule->boite) == 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                                <option value="Automatique" {{ old('boite', $vehicule->boite) == 'Automatique' ? 'selected' : '' }}>Automatique</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kilométrage</label>
                            <div class="input-group">
                                <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', $vehicule->kilometrage) }}">
                                <span class="input-group-text">km</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Carrosserie</label>
                            <input type="text" name="carrosserie" class="form-control" value="{{ old('carrosserie', $vehicule->carrosserie) }}">
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Mettre à jour le Véhicule
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection