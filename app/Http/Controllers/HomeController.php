<?php
/**
 * ============================================================================
 * CONTRÔLEUR DE LA PAGE D'ACCUEIL (HomeController)
 * ============================================================================
 * 
 * Ce contrôleur gère l'affichage de la page d'accueil du site.
 * Il récupère les statistiques du garage pour les afficher sur le dashboard.
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

// Importation des classes nécessaires
use App\Http\Controllers\Controller;  // Contrôleur de base Laravel
use Illuminate\Http\Request;          // Classe pour gérer les requêtes HTTP

// Importation des modèles pour accéder aux données
use App\Models\Vehicule;              // Modèle pour les véhicules
use App\Models\Reparation;            // Modèle pour les réparations
use App\Models\Technicien;            // Modèle pour les techniciens

class HomeController extends Controller
{
    /**
     * ========================================================================
     * AFFICHER LA PAGE D'ACCUEIL
     * ========================================================================
     * 
     * Cette méthode récupère toutes les statistiques nécessaires pour
     * afficher le tableau de bord sur la page d'accueil :
     * - Nombre total de véhicules
     * - Nombre total de techniciens
     * - Nombre total de réparations
     * - Les 5 dernières réparations
     * 
     * @return \Illuminate\View\View  Retourne la vue home avec les statistiques
     */
    public function index()
    {
        // Créer un tableau associatif contenant toutes les statistiques
        $stats = [
            // Compter le nombre total de véhicules dans la base de données
            // Vehicule::count() exécute : SELECT COUNT(*) FROM vehicules
            'vehicules' => Vehicule::count(),
            
            // Compter le nombre total de techniciens
            // Technicien::count() exécute : SELECT COUNT(*) FROM techniciens
            'techniciens' => Technicien::count(),
            
            // Compter le nombre total de réparations
            // Reparation::count() exécute : SELECT COUNT(*) FROM reparations
            'reparations' => Reparation::count(),
            
            // Récupérer les 5 dernières réparations avec leurs véhicules associés
            // - with('vehicule') : Charge la relation vehicule (évite le problème N+1)
            // - latest('date') : Trie par date décroissante (plus récent en premier)
            // - take(5) : Limite à 5 résultats
            // - get() : Exécute la requête et retourne une Collection
            'dernieres_reparations' => Reparation::with('vehicule')->latest('date')->take(5)->get()
        ];

        // Retourner la vue 'home' en passant les statistiques
        // compact('stats') est équivalent à ['stats' => $stats]
        return view('home', compact('stats'));
    }
} 
