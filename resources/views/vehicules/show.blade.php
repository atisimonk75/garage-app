@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('vehicules.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Détails du Véhicule</h1>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="card-title mb-0">{{ $vehicule->immatriculation }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Marque & Modèle</label>
                        <p class="fs-5">{{ $vehicule->marque }} {{ $vehicule->modele }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Année</label>
                        <p class="fs-5">{{ $vehicule->annee ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Énergie</label>
                        <p class="fs-5">{{ $vehicule->energie ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Boîte</label>
                        <p class="fs-5">{{ $vehicule->boite ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Kilométrage</label>
                        <p class="fs-5">{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Couleur</label>
                        <p class="fs-5">{{ $vehicule->couleur ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Carrosserie</label>
                        <p class="fs-5">{{ $vehicule->carrosserie ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning text-dark">
                        <i class="fa-solid fa-pencil me-1"></i>Modifier
                    </a>
                </div>
            </div>
        </div>

        <h3 class="mt-5 mb-3"><i class="fa-solid fa-wrench me-2"></i>Historique des Réparations</h3>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Technicien</th>
                            <th>Objet</th>
                            <th>Durée</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicule->reparations as $reparation)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</td>
                            <td>{{ $reparation->technicien->nom ?? 'N/A' }}</td>
                            <td>{{ $reparation->objet_reparation }}</td>
                            <td>{{ $reparation->duree_main_oeuvre }} min</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Aucune réparation enregistrée pour ce véhicule.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection