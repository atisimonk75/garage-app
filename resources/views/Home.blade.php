@extends('layouts.app')

@section('content')

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide hero-section" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" data-bs-interval="15000">
            <video controls width="100%" poster="img/slider1.jpg" autoplay muted loop style="object-fit: cover; height: 100%; width: 100%;">
                <source src="{{ asset('videos/14.mp4') }}" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
            <div class="hero-overlay"></div>
            <div class="carousel-caption hero-content">
                <div class="animate-in">
                    <h2 class="hero-title">Bienvenue chez Petruce Garage</h2>
                    <p class="hero-subtitle">Votre partenaire de confiance pour l'entretien et la réparation automobile. Profitez d'un service rapide et soigné.</p>
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">
                            <i class="fa-solid fa-user-plus me-2"></i>S'inscrire
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item h-100" data-bs-interval="5000">
            <img src="{{ asset('img/slider2.jpg') }}" class="d-block w-100 h-100" alt="Expertise technique">
            <div class="hero-overlay"></div>
            <div class="carousel-caption hero-content">
                <div class="animate-in">
                    <h2 class="hero-title">Expertise Technique Avancée</h2>
                    <p class="hero-subtitle">Nos mécaniciens qualifiés utilisent des outils de pointe pour diagnostiquer et réparer votre véhicule, quelle que soit la marque.</p>
                </div>
            </div>
        </div>
        <div class="carousel-item h-100" data-bs-interval="15000">
             <video controls width="100%" poster="img/slider3.jpg" autoplay muted loop style="object-fit: cover; height: 100%; width: 100%;">
                <source src="{{ asset('videos/13.mp4') }}" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
            <div class="hero-overlay"></div>
            <div class="carousel-caption hero-content">
                <div class="animate-in">
                    <h2 class="hero-title">Engagement Qualité & Sécurité</h2>
                    <p class="hero-subtitle">Nous garantissons des pièces d'origine et une main-d'œuvre certifiée pour assurer votre sécurité sur la route.</p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Stats Section -->
<div class="container my-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card primary card-gradient animate-in">
                <div class="stat-icon primary">
                    <i class="fa-solid fa-car"></i>
                </div>
                <div class="stat-number">{{ $stats['vehicules'] }}</div>
                <div class="stat-label">Véhicules en Gestion</div>
                <a href="{{ route('vehicules.index') }}" class="btn btn-outline-primary mt-3 btn-sm">Voir le parc</a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card success card-gradient animate-in" style="animation-delay: 0.1s;">
                <div class="stat-icon success">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <div class="stat-number">{{ $stats['reparations'] }}</div>
                <div class="stat-label">Interventions Réalisées</div>
                <a href="{{ route('reparations.index') }}" class="btn btn-outline-primary mt-3 btn-sm">Gérer</a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card secondary card-gradient animate-in" style="animation-delay: 0.2s;">
                <div class="stat-icon secondary">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-number">{{ $stats['techniciens'] }}</div>
                <div class="stat-label">Techniciens Experts</div>
                <a href="{{ route('techniciens.index') }}" class="btn btn-outline-primary mt-3 btn-sm">L'équipe</a>
            </div>
        </div>
    </div>

    <!-- Recent Interventions -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-11">
            <div class="card card-gradient">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0 fw-bold" style="color: var(--color-primary);">
                            <i class="fa-solid fa-clock-rotate-left me-2" style="color: var(--color-secondary);"></i>Dernières Interventions
                        </h3>
                        <a href="{{ route('reparations.create') }}" class="btn btn-primary animate-fade-in">
                            <i class="fa-solid fa-plus me-2"></i>Nouvelle Intervention
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Véhicule</th>
                                    <th>Description</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['dernieres_reparations'] as $rep)
                                <tr onclick="window.location='{{ route('reparations.show', $rep) }}'">
                                    <td>
                                        <span class="badge bg-light text-dark px-3 py-2" style="font-weight: 500;">
                                            {{ \Carbon\Carbon::parse($rep->date)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(85, 50, 50, 0.1) 0%, rgba(45, 10, 10, 0.1) 100%);">
                                                <i class="fa-solid fa-car text-danger"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="color: #2d3748;">{{ $rep->vehicule->immatriculation }}</div>
                                                <div class="small text-muted">{{ $rep->vehicule->marque }} {{ $rep->vehicule->modele }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color: #4a5568;">{{ \Illuminate\Support\Str::limit($rep->objet_reparation, 50) }}</td>
                                    <td class="text-end">
                                        <i class="fa-solid fa-chevron-right" style="color: #cbd5e0;"></i>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div style="opacity: 0.3;">
                                            <i class="fa-solid fa-inbox fs-1 d-block mb-3"></i>
                                            <p class="text-muted mb-0">Aucune intervention récente</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-in {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection