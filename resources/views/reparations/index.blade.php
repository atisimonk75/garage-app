@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-wrench me-2"></i>Liste des Réparations</h1>
        <a href="{{ route('reparations.create') }}" class="btn btn-primary animate-fade-in">
            <i class="fa-solid fa-plus me-1"></i>Nouvelle Réparation
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Véhicule</th>
                            <th>Technicien</th>
                            <th>Durée (MO)</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reparations as $reparation)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($reparation->date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="fw-bold">{{ $reparation->vehicule->immatriculation }}</span><br>
                                <small class="text-muted">{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</small>
                            </td>
                            <td>
                                @if($reparation->technicien)
                                    {{ $reparation->technicien->nom }} {{ $reparation->technicien->prenom }}
                                @else
                                    <span class="text-danger">Non assigné</span>
                                @endif
                            </td>
                            <td>{{ $reparation->duree_main_oeuvre }} min</td>
                            <td>{{ Str::limit($reparation->objet_reparation, 50) }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('reparations.destroy', $reparation) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette réparation ?')">
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
                            <td colspan="6" class="text-center py-4 text-muted">Aucune réparation enregistrée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection