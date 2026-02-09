@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('reparations.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="mb-0">Détails de l'intervention</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <h3 class="card-title mb-0">Intervention du {{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</h3>
                    @php
                        $statusClasses = [
                            'En attente' => 'bg-secondary text-white',
                            'En cours' => 'bg-primary text-white',
                            'Terminée' => 'bg-success text-white',
                        ];
                        $currentStatus = $reparation->statut ?? 'En attente';
                    @endphp
                    <span class="badge {{ $statusClasses[$currentStatus] ?? 'bg-secondary' }}">{{ $currentStatus }}</span>
                </div>
                <span class="badge bg-dark text-white">{{ $reparation->duree_main_oeuvre }} min</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="text-muted text-uppercase small fw-bold mb-2">Véhicule Concerné</h5>
                        <div class="d-flex align-items-center bg-light p-3 rounded">
                            <i class="fa-solid fa-car fs-2 text-primary me-3"></i>
                            <div>
                                <a href="{{ route('vehicules.show', $reparation->vehicule) }}" class="fw-bold fs-5 text-decoration-none text-dark">
                                    {{ $reparation->vehicule->immatriculation }}
                                </a>
                                <div class="small text-muted">{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-muted text-uppercase small fw-bold mb-2">Technicien en charge</h5>
                        <div class="d-flex align-items-center bg-light p-3 rounded">
                            <i class="fa-solid fa-id-badge fs-2 text-info me-3"></i>
                            <div>
                                @if($reparation->technicien)
                                    <a href="{{ route('techniciens.show', $reparation->technicien) }}" class="fw-bold fs-5 text-decoration-none text-dark">
                                        {{ $reparation->technicien->nom }} {{ $reparation->technicien->prenom }}
                                    </a>
                                    <div class="small text-muted">{{ $reparation->technicien->specialite ?? 'Généraliste' }}</div>
                                @else
                                    <span class="text-danger fw-bold">Non assigné</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h5 class="text-muted text-uppercase small fw-bold mb-2">Description des travaux</h5>
                        <div class="p-3 border rounded bg-white">
                            {{ $reparation->objet_reparation }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3 d-flex justify-content-end gap-2">
                    <button onclick="window.print()" class="btn btn-secondary">
                        <i class="fa-solid fa-print me-1"></i>Imprimer
                    </button>
                    <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil me-1"></i>Modifier
                    </a>
                    <form action="{{ route('reparations.destroy', $reparation) }}" method="POST" onsubmit="return confirm('Supprimer cette intervention ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection