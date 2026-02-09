@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-car me-2"></i>Liste des Véhicules</h1>
        <a href="{{ route('vehicules.create') }}" class="btn btn-primary animate-fade-in">
            <i class="fa-solid fa-plus me-1"></i>Nouveau Véhicule
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('vehicules.index') }}" method="GET" class="mb-0">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Rechercher par immatriculation ou marque..." value="{{ request('search') }}">
                    <button class="btn btn-primary animate-fade-in" type="submit">Rechercher</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Immatriculation</th>
                            <th>Marque & Modèle</th>
                            <th>Année</th>
                            <th>Kilométrage</th>
                            <th>Énergie</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicules as $vehicule)
                        <tr>
                            <td class="fw-bold text-primary">{{ $vehicule->immatriculation }}</td>
                            <td>{{ $vehicule->marque }} {{ $vehicule->modele }}</td>
                            <td>{{ $vehicule->annee ?? '-' }}</td>
                            <td>{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</td>
                            <td>
                                <span class="badge bg-secondary">{{ $vehicule->energie ?? 'Non spécifié' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce véhicule ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Aucun véhicule enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection