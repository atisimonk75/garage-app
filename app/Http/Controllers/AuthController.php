<?php
/**
 * ============================================================================
 * CONTRÔLEUR D'AUTHENTIFICATION (AuthController)
 * ============================================================================
 * 
 * Ce contrôleur gère toutes les fonctionnalités liées à l'authentification
 * des utilisateurs : connexion, inscription, déconnexion et OAuth Google.
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

// Importation des classes nécessaires
use App\Models\User;                          // Modèle User pour interagir avec la table users
use Illuminate\Http\Request;                   // Classe pour gérer les requêtes HTTP
use Illuminate\Support\Facades\Auth;           // Facade pour l'authentification
use Illuminate\Support\Facades\Hash;           // Facade pour le hachage des mots de passe
use Illuminate\Validation\Rules;               // Règles de validation Laravel
use Laravel\Socialite\Facades\Socialite;       // Package pour l'authentification OAuth (Google, etc.)
use Illuminate\Support\Str;                    // Classe utilitaire pour les chaînes de caractères

class AuthController extends Controller
{
    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE CONNEXION
     * ========================================================================
     * 
     * Cette méthode affiche simplement la vue du formulaire de connexion.
     * Elle est appelée lorsque l'utilisateur accède à la route GET /login
     * 
     * @return \Illuminate\View\View  Retourne la vue auth.login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ========================================================================
     * TRAITER LA CONNEXION DE L'UTILISATEUR
     * ========================================================================
     * 
     * Cette méthode traite le formulaire de connexion soumis par l'utilisateur.
     * Elle valide les données, vérifie les identifiants et connecte l'utilisateur.
     * 
     * @param  Request $request  La requête HTTP contenant email et mot de passe
     * @return \Illuminate\Http\RedirectResponse  Redirection vers home ou retour avec erreur
     */
    public function login(Request $request)
    {
        // Étape 1 : Valider les données du formulaire
        // - email : obligatoire et doit être un format email valide
        // - password : obligatoire
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Étape 2 : Tenter de connecter l'utilisateur avec les identifiants
        // Auth::attempt() vérifie si l'email existe et si le mot de passe correspond
        if (Auth::attempt($credentials)) {
            // Sécurité : Régénérer l'ID de session pour éviter les attaques de fixation de session
            $request->session()->regenerate();

            // Rediriger vers la page d'accueil avec un message de succès
            // intended() redirige vers la page que l'utilisateur voulait visiter avant d'être redirigé vers login
            return redirect()->intended(route('home'))->with('success', 'Vous êtes connecté avec succès !');
        }

        // Étape 3 : Si les identifiants sont incorrects, retourner à la page de connexion avec une erreur
        // onlyInput('email') conserve l'email saisi pour que l'utilisateur n'ait pas à le retaper
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE D'INSCRIPTION
     * ========================================================================
     * 
     * Cette méthode affiche la vue du formulaire d'inscription.
     * Appelée lors de l'accès à la route GET /register
     * 
     * @return \Illuminate\View\View  Retourne la vue auth.register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * ========================================================================
     * TRAITER L'INSCRIPTION D'UN NOUVEL UTILISATEUR
     * ========================================================================
     * 
     * Cette méthode traite le formulaire d'inscription :
     * 1. Valide les données saisies
     * 2. Crée un nouvel utilisateur en base de données
     * 3. Connecte automatiquement l'utilisateur
     * 
     * @param  Request $request  La requête contenant name, email, password
     * @return \Illuminate\Http\RedirectResponse  Redirection vers home après inscription
     */
    public function register(Request $request)
    {
        // Étape 1 : Valider toutes les données du formulaire
        // - name : obligatoire, chaîne de caractères, max 255 caractères
        // - email : obligatoire, format email, unique dans la table users
        // - password : obligatoire, doit correspondre à password_confirmation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Étape 2 : Créer le nouvel utilisateur dans la base de données
        // Hash::make() crypte le mot de passe pour la sécurité (ne jamais stocker en clair !)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Étape 3 : Connecter automatiquement le nouvel utilisateur
        Auth::login($user);

        // Étape 4 : Rediriger vers la page d'accueil avec message de bienvenue
        return redirect(route('home'))->with('success', 'Inscription réussie ! Bienvenue.');
    }

    /**
     * ========================================================================
     * DÉCONNECTER L'UTILISATEUR
     * ========================================================================
     * 
     * Cette méthode déconnecte l'utilisateur actuellement connecté.
     * Elle invalide la session et régénère le token CSRF pour la sécurité.
     * 
     * @param  Request $request  La requête HTTP
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la page d'accueil
     */
    public function logout(Request $request)
    {
        // Étape 1 : Déconnecter l'utilisateur
        Auth::logout();

        // Étape 2 : Invalider complètement la session actuelle
        $request->session()->invalidate();

        // Étape 3 : Régénérer le token CSRF pour la sécurité
        $request->session()->regenerateToken();

        // Étape 4 : Rediriger vers la page d'accueil avec message de confirmation
        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }

    /**
     * ========================================================================
     * REDIRIGER VERS LE FOURNISSEUR OAUTH (GOOGLE)
     * ========================================================================
     * 
     * Cette méthode redirige l'utilisateur vers la page de connexion du fournisseur
     * OAuth (Google dans notre cas). Le fournisseur demandera à l'utilisateur
     * d'autoriser notre application.
     * 
     * @param  string $provider  Le nom du fournisseur OAuth (google, facebook, etc.)
     * @return \Symfony\Component\HttpFoundation\RedirectResponse  Redirection vers Google
     */
    public function redirectToProvider($provider)
    {
        // Utiliser Socialite pour rediriger vers la page de connexion du fournisseur
        // Le fournisseur est dynamique ($provider peut être 'google', 'facebook', etc.)
        return Socialite::driver($provider)->redirect();
    }

    /**
     * ========================================================================
     * GÉRER LE RETOUR DU FOURNISSEUR OAUTH (CALLBACK)
     * ========================================================================
     * 
     * Cette méthode est appelée lorsque l'utilisateur revient de Google après
     * s'être authentifié. Elle :
     * 1. Récupère les informations de l'utilisateur depuis Google
     * 2. Crée un compte s'il n'existe pas, ou récupère l'existant
     * 3. Connecte l'utilisateur
     * 
     * @param  string $provider  Le nom du fournisseur OAuth
     * @return \Illuminate\Http\RedirectResponse  Redirection vers home ou login si erreur
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Étape 1 : Récupérer les informations de l'utilisateur depuis le fournisseur
            // Socialite échange le code d'autorisation contre les données utilisateur
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Si une erreur survient (ex: l'utilisateur a annulé), rediriger vers login
            return redirect(route('login'))->withErrors(['email' => 'Erreur de connexion avec ' . $provider]);
        }

        // Étape 2 : Chercher si un utilisateur avec cet email existe déjà
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // Étape 3a : Si aucun utilisateur n'existe, en créer un nouveau
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(), // Nom ou pseudo
                'email' => $socialUser->getEmail(),                              // Email du compte Google
                'password' => Hash::make(Str::random(24)),                       // Mot de passe aléatoire (non utilisé)
                "{$provider}_id" => $socialUser->getId(),                        // ID Google de l'utilisateur
                'avatar' => $socialUser->getAvatar(),                            // Photo de profil Google
            ]);
        } else {
            // Étape 3b : Si l'utilisateur existe, mettre à jour son ID social s'il n'en a pas
            if (empty($user->{"{$provider}_id"})) {
                $user->update([
                    "{$provider}_id" => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar() ?? $user->avatar,
                ]);
            }
        }

        // Étape 4 : Connecter l'utilisateur
        Auth::login($user);

        // Étape 5 : Rediriger vers la page d'accueil avec message de bienvenue personnalisé
        return redirect(route('home'))->with('success', "Bienvenue, {$user->name} !");
    }
}
