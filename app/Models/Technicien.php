<?php
/**
 * ============================================================================
 * MODÈLE TECHNICIEN
 * ============================================================================
 * 
 * Ce modèle représente la table 'techniciens' dans la base de données.
 * Il gère les informations des techniciens du garage qui effectuent
 * les réparations sur les véhicules.
 * 
 * Table : techniciens
 * 
 * Relations :
 * - Un technicien peut effectuer plusieurs réparations (hasMany)
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;                    // Classe de base Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;     // Trait pour les factories

class Technicien extends Model
{
    /**
     * Trait HasFactory : Permet d'utiliser les factories pour créer
     * des techniciens de test dans les tests unitaires
     */
    use HasFactory;

    /**
     * ========================================================================
     * ATTRIBUTS REMPLISSABLES (Mass Assignment)
     * ========================================================================
     * 
     * Liste des champs qui peuvent être assignés en masse lors de la
     * création ou modification d'un technicien.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'nom',          // Nom de famille du technicien
        'prenom',       // Prénom du technicien
        'specialite'    // Spécialité du technicien (ex: mécanique, électricité, carrosserie)
    ];

    /**
     * ========================================================================
     * RELATION : Réparations effectuées par le technicien
     * ========================================================================
     * 
     * Un technicien peut effectuer plusieurs réparations (relation One-to-Many).
     * Cette méthode permet d'accéder à toutes les réparations d'un technicien.
     * 
     * Utilisation : $technicien->reparations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reparations()
    {
        // hasMany signifie : ce technicien a effectué plusieurs réparations
        // La clé étrangère 'technicien_id' est automatiquement déduite
        return $this->hasMany(Reparation::class);
    }
}