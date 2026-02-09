{{--
============================================================================
TEMPLATE PRINCIPAL DE L'APPLICATION (app.blade.php)
============================================================================

Ce fichier est le layout principal de l'application. Il définit la structure
HTML de base qui est héritée par toutes les autres vues.

Contenu :
- <head> : Meta, CSS, polices, styles personnalisés
- <nav> : Barre de navigation responsive
- <body> : Contenu principal + Footer

Utilisation dans les autres vues :
  @extends('layouts.app')
  @section('content')
      <!-- Contenu de la page -->
  @endsection

@package Resources/Views/Layouts
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    {{-- ================================================================
         META TAGS
         - charset : Encodage des caractères (UTF-8)
         - viewport : Responsive design pour mobile
    ================================================================ --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Titre de la page affiché dans l'onglet du navigateur --}}
    <title>Petruce Garage - Excellence Automobile</title>
    
    {{-- Favicon (icône dans l'onglet du navigateur) --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    {{-- ================================================================
         POLICES GOOGLE FONTS
         - Inter : Police moderne et lisible
    ================================================================ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- ================================================================
         CSS EXTERNES (CDN)
         - Bootstrap 5 : Framework CSS responsive
         - Font Awesome 6 : Bibliothèque d'icônes
    ================================================================ --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- CSS personnalisé pour les animations --}}
    <link rel="stylesheet" href="/css/animations.css">
    
    {{-- ================================================================
         STYLES CSS PERSONNALISÉS
         Ces styles définissent l'apparence unique de l'application
    ================================================================ --}}
    <style>
        /* Reset CSS - Supprime les marges par défaut */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* ============================================================
           VARIABLES CSS (Custom Properties)
           Définies ici pour être réutilisées dans tout le CSS
        ============================================================ */
        :root {
            /* Dégradés de couleurs */
            --gradient-primary: linear-gradient(135deg, #0f172a 0%, #1351ceff 100%);
            --gradient-secondary: linear-gradient(135deg, #53442bff 0%, #fffbf6d5 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            
            /* Ombres portées (shadows) */
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* ============================================================
           STYLES DU BODY
           Police Inter, fond dégradé, couleur de texte
        ============================================================ */
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(to bottom, #9c9c70ff 0%, #9c630eff 100%);
            color: #ff9f0eff;
            overflow-x: hidden; /* Empêche le scroll horizontal */
        }

        /* ============================================================
           NAVBAR (Barre de navigation)
           Effet glassmorphism avec backdrop-filter
        ============================================================ */
        .navbar {
            background: rgba(25, 145, 192, 0.34) !important;
            backdrop-filter: saturate(180%) blur(20px); /* Effet verre dépoli */
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        /* Logo de la marque avec dégradé de texte */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }
        
        /* Style des liens de navigation */
        .nav-link {
            color: #4a5568 !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        /* Ligne de soulignement animée sous les liens */
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }
        
        /* Affiche la ligne au survol ou si actif */
        .nav-link:hover::before,
        .nav-link.active::before {
            width: 60%;
        }
        
        /* Couleur de fond au survol */
        .nav-link:hover,
        .nav-link.active {
            color: #251f2b !important;
            background: rgba(139, 0, 0, 0.05);
        }

        /* ============================================================
           CARDS (Cartes)
           Design moderne avec coins arrondis et ombres
        ============================================================ */
        .card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        /* Animation au survol - la carte monte légèrement */
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        
        /* Carte avec ligne colorée en haut */
        .card-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .card-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        /* ============================================================
           BOUTONS
           Style moderne avec dégradés et animations
        ============================================================ */
        .btn {
            border-radius: 12px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
        }
        
        /* Bouton primaire avec dégradé */
        .btn-primary {
            background: var(--gradient-primary);
            box-shadow: 0 4px 15px rgba(30, 2, 32, 0.94);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.5);
        }
        
        /* Bouton outline (contour) */
        .btn-outline-primary {
            border: 2px solid #0f172a;
            color: #0f172a;
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
        }

        /* ============================================================
           SECTION HERO (Bannière principale)
        ============================================================ */
        .hero-section {
            position: relative;
            height: 85vh;
            overflow: hidden;
            margin-bottom: 3rem;
        }
        
        /* Overlay semi-transparent sur l'image */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 139, 81, 0.3) 0%, rgba(45, 10, 10, 0.2) 100%);
            z-index: 1;
        }
        
        /* Contenu centré dans le hero */
        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            opacity: 0.95;
        }

        /* ============================================================
           CARTES DE STATISTIQUES
           Affichent les compteurs sur la page d'accueil
        ============================================================ */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Ligne colorée en haut de la carte */
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
        }
        
        /* Couleurs différentes selon le type */
        .stat-card.primary::before { background: var(--gradient-primary); }
        .stat-card.success::before { background: var(--gradient-success); }
        .stat-card.secondary::before { background: var(--gradient-secondary); }
        
        /* Icône dans la carte de stats */
        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        
        .stat-icon.primary { background: linear-gradient(135deg, rgba(15, 23, 42, 0.1) 0%, rgba(30, 41, 59, 0.1) 100%); color: #0f172a; }
        .stat-icon.success { background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%); color: #10b981; }
        .stat-icon.secondary { background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%); color: #f59e0b; }
        
        /* Nombre affiché (grand) */
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        /* Label sous le nombre */
        .stat-label {
            color: #001330;
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* ============================================================
           TABLEAUX MODERNES
        ============================================================ */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-modern thead th {
            background: #f7fafc;
            color: #4a5568;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
        }
        
        .table-modern tbody tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .table-modern tbody tr:hover {
            background: #f7fafc;
            transform: scale(1.01);
        }
        
        .table-modern tbody td {
            padding: 1.2rem 1rem;
            border: none;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        /* ============================================================
           CAROUSEL (Diaporama)
        ============================================================ */
        .carousel-item img {
            height: 100%;
            object-fit: cover;
        }
        
        .carousel-caption {
            bottom: 50%;
            transform: translateY(50%);
        }
        
        .carousel-caption h2 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
        }
        
        .carousel-caption p {
            font-size: 1.2rem;
            font-weight: 300;
        }

        /* ============================================================
           ANIMATIONS
        ============================================================ */
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
        
        .animate-in {
            animation: fadeInUp 0.6s ease-out;
        }

        /* ============================================================
           ALERTES MODERNES
        ============================================================ */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 178, 172, 0.1) 100%);
            border-left: 4px solid #48bb78;
            color: #2f855a;
        }

        /* ============================================================
           STYLES D'IMPRESSION
           Cache les éléments non nécessaires à l'impression
        ============================================================ */
        @media print {
            .navbar, .btn, .alert { display: none !important; }
            .card { box-shadow: none !important; transform: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body>
    {{-- ================================================================
         BARRE DE NAVIGATION
         - fixed-top : Reste fixée en haut lors du scroll
         - navbar-expand-lg : Menu hamburger sur mobile
    ================================================================ --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            {{-- Logo et nom du garage --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa-solid fa-gear me-2 text-warning"></i>Petruce Garage
            </a>
            
            {{-- Bouton hamburger pour mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            {{-- Menu de navigation --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    {{-- Lien Accueil --}}
                    <li class="nav-item">
                        {{-- La classe 'active' est ajoutée si on est sur la route 'home' --}}
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fa-solid fa-house me-1"></i>Accueil
                        </a>
                    </li>
                    
                    {{-- Lien Véhicules --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vehicules.*') ? 'active' : '' }}" href="{{ route('vehicules.index') }}">
                            <i class="fa-solid fa-car me-1"></i>Véhicules
                        </a>
                    </li>
                    
                    {{-- Lien Techniciens --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('techniciens.*') ? 'active' : '' }}" href="{{ route('techniciens.index') }}">
                            <i class="fa-solid fa-users me-1"></i>Techniciens
                        </a>
                    </li>
                    
                    {{-- Lien Réparations --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reparations.*') ? 'active' : '' }}" href="{{ route('reparations.index') }}">
                            <i class="fa-solid fa-wrench me-1"></i>Réparations
                        </a>
                    </li>
                    
                    {{-- Séparateur vertical --}}
                    <li class="nav-item border-start mx-3 d-none d-lg-block" style="height: 24px; border-color: #cbd5e1 !important;"></li>

                    {{-- ============================================================
                         SECTION AUTHENTIFICATION
                         @guest : Affiché si l'utilisateur n'est PAS connecté
                         @else  : Affiché si l'utilisateur EST connecté
                    ============================================================ --}}
                    @guest
                        {{-- Lien vers la page de connexion --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        {{-- Bouton d'inscription (mis en valeur) --}}
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}" style="border-radius: 20px;">Inscription</a>
                        </li>
                    @else
                        {{-- Menu déroulant avec le nom de l'utilisateur connecté --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                <li>
                                    {{-- Formulaire de déconnexion (POST pour la sécurité) --}}
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf  {{-- Token CSRF obligatoire pour les formulaires POST --}}
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Espace pour compenser la navbar fixe (76px de hauteur) --}}
    <div style="height: 76px;"></div>

    {{-- ================================================================
         CONTENU PRINCIPAL
         @yield('content') : Ici sera injecté le contenu des autres vues
    ================================================================ --}}
    <div class="container-fluid px-0">
        {{-- Affichage des messages de succès stockés en session --}}
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show animate-in" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        {{-- Point d'injection du contenu des vues enfants --}}
        @yield('content')
    </div>

    {{-- ================================================================
         FOOTER (Pied de page)
    ================================================================ --}}
    <footer class="text-white py-5 mt-auto" style="background: linear-gradient(135deg, #000046 0%, #1CB5E0 100%);">
        <div class="container">
            <div class="row g-4 justify-content-between">
                {{-- Colonne 1 : Présentation et réseaux sociaux --}}
                <div class="col-lg-4 col-md-6">
                    <h4 class="fw-bold mb-4 text-white">Petruce Garage</h4>
                    <p class="text-white-50">Votre partenaire de confiance pour l'entretien et la réparation automobile. Expertise, qualité et transparence.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white fs-5 hover-scale"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-white fs-5 hover-scale"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="text-white fs-5 hover-scale"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white fs-5 hover-scale"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
                
                {{-- Colonne 2 : Navigation rapide --}}
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3 text-white">Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">Accueil</a></li>
                        <li class="mb-2"><a href="{{ route('vehicules.index') }}" class="text-white-50 text-decoration-none hover-white">Véhicules</a></li>
                        <li class="mb-2"><a href="{{ route('techniciens.index') }}" class="text-white-50 text-decoration-none hover-white">Techniciens</a></li>
                        <li class="mb-2"><a href="{{ route('reparations.index') }}" class="text-white-50 text-decoration-none hover-white">Réparations</a></li>
                    </ul>
                </div>

                {{-- Colonne 3 : Informations de contact --}}
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3 text-white">Contact</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2 text-info"></i> Kpalimé- Kpodji</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2 text-info"></i> +228 91 08 49 59</li>
                        <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-info"></i> atisimonk75@gmail.com</li>
                        <li class="mb-2"><i class="fa-solid fa-clock me-2 text-info"></i> Lun - Sam: 8h00 - 19h00</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 border-secondary opacity-25">
            
            {{-- Copyright et liens légaux --}}
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    {{-- date('Y') affiche automatiquement l'année en cours --}}
                    <p class="mb-0 text-white-50 small">&copy; {{ date('Y') }} Petruce Garage. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white-50 small text-decoration-none me-3 hover-white">Mentions Légales</a>
                    <a href="#" class="text-white-50 small text-decoration-none hover-white">Politique de Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>
    
    {{-- Styles supplémentaires pour les effets hover --}}
    <style>
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.1); color: var(--color-primary) !important; }
        .hover-white { transition: color 0.2s; }
        .hover-white:hover { color: white !important; }
    </style>

    {{-- ================================================================
         JAVASCRIPT
         Bootstrap Bundle inclut Popper.js pour les dropdowns/tooltips
    ================================================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>