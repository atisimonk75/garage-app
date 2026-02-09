@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('reparations.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Modifier la Réparation</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('reparations.update', $reparation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Véhicule *</label>
                            <select name="vehicule_id" class="form-select @error('vehicule_id') is-invalid @enderror" required>
                                @foreach($vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}" {{ old('vehicule_id', $reparation->vehicule_id) == $vehicule->id ? 'selected' : '' }}>
                                        {{ $vehicule->immatriculation }} - {{ $vehicule->marque }} {{ $vehicule->modele }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Technicien</label>
                            <select name="technicien_id" class="form-select @error('technicien_id') is-invalid @enderror">
                                <option value="">Assigner un technicien...</option>
                                @foreach($techniciens as $technicien)
                                    <option value="{{ $technicien->id }}" {{ old('technicien_id', $reparation->technicien_id) == $technicien->id ? 'selected' : '' }}>
                                        {{ $technicien->nom }} {{ $technicien->prenom }} ({{ $technicien->specialite }})
                                    </option>
                                @endforeach
                            </select>
                            @error('technicien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date de réparation *</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $reparation->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Durée (minutes)</label>
                            <div class="input-group">
                                <input type="number" name="duree_main_oeuvre" class="form-control @error('duree_main_oeuvre') is-invalid @enderror" value="{{ old('duree_main_oeuvre', $reparation->duree_main_oeuvre) }}">
                                <span class="input-group-text">min</span>
                            </div>
                            @error('duree_main_oeuvre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Objet de la réparation *</label>
                            <textarea name="objet_reparation" class="form-control @error('objet_reparation') is-invalid @enderror" rows="5" required>{{ old('objet_reparation', $reparation->objet_reparation) }}</textarea>
                            @error('objet_reparation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                                <i class="fa-solid fa-calendar-check me-2"></i>Mettre à jour la Réparation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection