@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('techniciens.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Profil du Technicien</h1>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white py-3">
                <h3 class="card-title mb-0 text-dark">{{ $technicien->nom }} {{ $technicien->prenom }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Spécialité</label>
                        <p class="fs-5">{{ $technicien->specialite ?? 'Généraliste' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Date d'inscription</label>
                        <p class="fs-5">{{ $technicien->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('techniciens.edit', $technicien) }}" class="btn btn-warning text-dark">
                        <i class="fa-solid fa-pencil me-1"></i>Modifier
                    </a>
                </div>
            </div>
        </div>

        <h3 class="mt-5 mb-3"><i class="fa-solid fa-wrench me-2"></i>Interventions Réalisées</h3>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Véhicule</th>
                            <th>Objet</th>
                            <th>Durée</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($technicien->reparations as $reparation)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('vehicules.show', $reparation->vehicule) }}" class="text-decoration-none">
                                    {{ $reparation->vehicule->immatriculation }}
                                </a>
                            </td>
                            <td>{{ $reparation->objet_reparation }}</td>
                            <td>{{ $reparation->duree_main_oeuvre }} min</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Aucune intervention enregistrée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection