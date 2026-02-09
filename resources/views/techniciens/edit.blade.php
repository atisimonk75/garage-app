@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('techniciens.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Modifier le Technicien</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('techniciens.update', $technicien) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom *</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $technicien->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prénom *</label>
                        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $technicien->prenom) }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Spécialité</label>
                        <input type="text" name="specialite" class="form-control @error('specialite') is-invalid @enderror" value="{{ old('specialite', $technicien->specialite) }}">
                        @error('specialite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                            <i class="fa-solid fa-user-check me-2"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection