@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-id-badge me-2"></i>Liste des Techniciens</h1>
        <a href="{{ route('techniciens.create') }}" class="btn btn-primary animate-fade-in">
            <i class="fa-solid fa-user-plus me-1"></i>Nouveau Technicien
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Spécialité</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($techniciens as $technicien)
                        <tr>
                            <td class="fw-bold">{{ $technicien->nom }} {{ $technicien->prenom }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $technicien->specialite ?? 'Généraliste' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('techniciens.show', $technicien) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('techniciens.edit', $technicien) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('techniciens.destroy', $technicien) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce technicien ?')">
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
                            <td colspan="3" class="text-center py-4 text-muted">Aucun technicien enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection