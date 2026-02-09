<?php
/**
 * ============================================================================
 * FICHIER DES ROUTES WEB (web.php)
 * ============================================================================
 * 
 * Ce fichier définit toutes les routes accessibles via le navigateur web.
 * Chaque route associe une URL à un contrôleur et une méthode.
 * 
 * Types de routes :
 * - Route::get()      : Requêtes GET (affichage)
 * - Route::post()     : Requêtes POST (soumission de formulaires)
 * - Route::put()      : Requêtes PUT (mise à jour)
 * - Route::delete()   : Requêtes DELETE (suppression)
 * - Route::resource() : Génère automatiquement les 7 routes CRUD
 * 
 * @package Routes
 */

use Illuminate\Support\Facades\Route;           // Facade pour définir les routes
use App\Http\Controllers\HomeController;        // Contrôleur de la page d'accueil
use App\Http\Controllers\VehiculeController;    // Contrôleur des véhicules
use App\Http\Controllers\TechnicienController;  // Contrôleur des techniciens
use App\Http\Controllers\ReparationController;  // Contrôleur des réparations
use App\Http\Controllers\AuthController;        // Contrôleur d'authentification

/**
 * ============================================================================
 * ROUTE DE LA PAGE D'ACCUEIL
 * ============================================================================
 * 
 * URL : /
 * Méthode HTTP : GET
 * Contrôleur : HomeController@index
 * Nom de la route : 'home'
 * 
 * Cette route affiche la page d'accueil avec les statistiques du garage.
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * ============================================================================
 * ROUTES D'AUTHENTIFICATION
 * ============================================================================
 * 
 * Groupe de routes géré par AuthController.
 * Route::controller() permet de spécifier le contrôleur une seule fois
 * pour tout le groupe.
 */
Route::controller(AuthController::class)->group(function () {
    
    /**
     * Page de connexion
     * GET /login : Affiche le formulaire de connexion
     * Nom : 'login' (utilisé par le middleware 'auth' pour rediriger ici)
     */
    Route::get('/login', 'showLogin')->name('login');
    
    /**
     * Traitement de la connexion
     * POST /login : Vérifie les identifiants et connecte l'utilisateur
     */
    Route::post('/login', 'login');
    
    /**
     * Page d'inscription
     * GET /register : Affiche le formulaire d'inscription
     * Nom : 'register'
     */
    Route::get('/register', 'showRegister')->name('register');
    
    /**
     * Traitement de l'inscription
     * POST /register : Crée un nouvel utilisateur et le connecte
     */
    Route::post('/register', 'register');
    
    /**
     * Déconnexion
     * POST /logout : Déconnecte l'utilisateur
     * Nom : 'logout'
     * Middleware 'auth' : Seuls les utilisateurs connectés peuvent se déconnecter
     */
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');

    /**
     * ========================================================================
     * ROUTES OAUTH (Connexion Sociale)
     * ========================================================================
     * 
     * Ces routes gèrent l'authentification via des services tiers (Google, Apple).
     * Le paramètre {provider} est dynamique et filtré pour n'accepter que
     * 'google' ou 'apple' grâce à where().
     */
    
    /**
     * Redirection vers le fournisseur OAuth
     * GET /login/google ou /login/apple
     * Redirige l'utilisateur vers la page de connexion Google/Apple
     * Nom : 'login.social'
     */
    Route::get('/login/{provider}', 'redirectToProvider')
        ->where('provider', 'google|apple')
        ->name('login.social');
    
    /**
     * Callback OAuth (retour du fournisseur)
     * GET /login/google/callback ou /login/apple/callback
     * Google/Apple redirige ici après authentification réussie
     */
    Route::get('/login/{provider}/callback', 'handleProviderCallback')
        ->where('provider', 'google|apple');
});

/**
 * ============================================================================
 * ROUTES CRUD : VÉHICULES
 * ============================================================================
 * 
 * Route::resource() génère automatiquement 7 routes CRUD :
 * 
 * | Méthode HTTP | URI                      | Action  | Nom de route         |
 * |--------------|--------------------------|---------|----------------------|
 * | GET          | /vehicules               | index   | vehicules.index      |
 * | GET          | /vehicules/create        | create  | vehicules.create     |
 * | POST         | /vehicules               | store   | vehicules.store      |
 * | GET          | /vehicules/{vehicule}    | show    | vehicules.show       |
 * | GET          | /vehicules/{vehicule}/edit| edit   | vehicules.edit       |
 * | PUT/PATCH    | /vehicules/{vehicule}    | update  | vehicules.update     |
 * | DELETE       | /vehicules/{vehicule}    | destroy | vehicules.destroy    |
 */
Route::resource('vehicules', VehiculeController::class);

/**
 * ============================================================================
 * ROUTES CRUD : TECHNICIENS
 * ============================================================================
 * 
 * Mêmes 7 routes CRUD que véhicules, mais pour les techniciens.
 * Préfixe : /techniciens
 */
Route::resource('techniciens', TechnicienController::class);

/**
 * ============================================================================
 * ROUTES CRUD : RÉPARATIONS
 * ============================================================================
 * 
 * Mêmes 7 routes CRUD que véhicules, mais pour les réparations.
 * Préfixe : /reparations
 */
Route::resource('reparations', ReparationController::class);