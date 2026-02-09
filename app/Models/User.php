<?php
/**
 * ============================================================================
 * MODÈLE USER (Utilisateur)
 * ============================================================================
 * 
 * Ce modèle représente la table 'users' dans la base de données.
 * Il gère les utilisateurs de l'application, y compris l'authentification
 * classique et OAuth (Google).
 * 
 * Table : users
 * 
 * @package App\Models
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;  // Décommenter pour activer la vérification d'email
use Illuminate\Database\Eloquent\Factories\HasFactory;     // Trait pour utiliser les factories dans les tests
use Illuminate\Foundation\Auth\User as Authenticatable;    // Classe de base pour l'authentification
use Illuminate\Notifications\Notifiable;                   // Trait pour envoyer des notifications

/**
 * Classe User
 * 
 * Cette classe étend Authenticatable (et non Model) car elle gère
 * l'authentification des utilisateurs avec toutes les fonctionnalités
 * de sécurité de Laravel (hachage de mot de passe, sessions, etc.)
 */
class User extends Authenticatable
{
    /**
     * Traits utilisés par ce modèle :
     * - HasFactory : Permet de créer des utilisateurs de test avec les factories
     * - Notifiable : Permet d'envoyer des notifications (email, SMS, etc.)
     */
    use HasFactory, Notifiable;

    /**
     * ========================================================================
     * ATTRIBUTS REMPLISSABLES (Mass Assignment)
     * ========================================================================
     * 
     * Ces attributs peuvent être assignés en masse lors de la création
     * ou modification d'un utilisateur. C'est une protection de sécurité
     * contre les attaques d'assignation en masse.
     * 
     * Exemple : User::create(['name' => 'John', 'email' => 'john@example.com', ...])
     * 
     * @var array<string>
     */
    protected $fillable = [
        'name',       // Nom complet de l'utilisateur
        'email',      // Adresse email (unique, utilisée pour la connexion)
        'password',   // Mot de passe (haché automatiquement)
        'google_id',  // ID unique Google pour OAuth (nullable)
        'apple_id',   // ID unique Apple pour OAuth (nullable)
        'avatar',     // URL de la photo de profil (nullable)
    ];

    /**
     * ========================================================================
     * ATTRIBUTS CACHÉS (Sérialisation)
     * ========================================================================
     * 
     * Ces attributs sont exclus lors de la conversion du modèle en
     * tableau ou JSON (par exemple dans les réponses API).
     * C'est important pour la sécurité : ne jamais exposer le mot de passe !
     * 
     * @var array<string>
     */
    protected $hidden = [
        'password',        // Le mot de passe ne doit JAMAIS être visible
        'remember_token',  // Token de "se souvenir de moi"
    ];

    /**
     * ========================================================================
     * CASTING DES ATTRIBUTS
     * ========================================================================
     * 
     * Définit comment certains attributs doivent être convertis
     * automatiquement lors de la lecture/écriture en base de données.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Convertit automatiquement en objet Carbon (date/heure)
            'email_verified_at' => 'datetime',
            // Hache automatiquement le mot de passe lors de l'assignation
            // Plus besoin d'utiliser Hash::make() explicitement !
            'password' => 'hashed',
        ];
    }
}
