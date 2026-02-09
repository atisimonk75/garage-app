<?php
/**
 * ============================================================================
 * MODÈLE REPARATION
 * ============================================================================
 * 
 * Ce modèle représente la table 'reparations' dans la base de données.
 * Il gère les réparations effectuées sur les véhicules par les techniciens.
 * 
 * Table : reparations
 * 
 * C'est une table pivot qui lie :
 * - Un véhicule (relation belongsTo)
 * - Un technicien (relation belongsTo, optionnel)
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;                    // Classe de base Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;     // Trait pour les factories

class Reparation extends Model
{
    /**
     * Trait HasFactory : Permet d'utiliser les factories pour créer
     * des réparations de test dans les tests unitaires
     */
    use HasFactory;

    /**
     * ========================================================================
     * ATTRIBUTS REMPLISSABLES (Mass Assignment)
     * ========================================================================
     * 
     * Champs de la table reparations :
     * 
     * - vehicule_id : Clé étrangère vers la table vehicules (obligatoire)
     * - technicien_id : Clé étrangère vers la table techniciens (optionnel)
     * - date : Date de la réparation
     * - duree_main_oeuvre : Durée du travail en heures (ou minutes selon config)
     * - objet_reparation : Description de la réparation effectuée
     * 
     * @var array<string>
     */
    protected $fillable = [
        "vehicule_id",       // ID du véhicule concerné (clé étrangère)
        "technicien_id",     // ID du technicien qui a fait la réparation (nullable)
        "date",              // Date de la réparation
        "duree_main_oeuvre", // Durée du travail (en heures ou minutes)
        "objet_reparation"   // Description de ce qui a été réparé
    ];

    /**
     * ========================================================================
     * CASTING DES ATTRIBUTS
     * ========================================================================
     * 
     * Définit comment certains attributs doivent être convertis
     * automatiquement lors de la lecture/écriture en base de données.
     * 
     * @var array<string, string>
     */
    protected $casts = [
        // Convertit automatiquement la date en objet Carbon
        // Permet d'utiliser : $reparation->date->format('d/m/Y')
        'date' => 'date',
    ];

    /**
     * ========================================================================
     * RELATION : Véhicule associé à la réparation
     * ========================================================================
     * 
     * Chaque réparation appartient à un véhicule (relation Many-to-One).
     * C'est l'inverse de la relation hasMany définie dans Vehicule.
     * 
     * Utilisation : $reparation->vehicule
     * Exemple : $reparation->vehicule->immatriculation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicule()
    {
        // belongsTo signifie : cette réparation appartient à un véhicule
        // La clé étrangère 'vehicule_id' est automatiquement déduite
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * ========================================================================
     * RELATION : Technicien ayant effectué la réparation
     * ========================================================================
     * 
     * Chaque réparation peut être effectuée par un technicien (optionnel).
     * La relation est nullable car une réparation peut ne pas avoir
     * de technicien assigné.
     * 
     * Utilisation : $reparation->technicien
     * Exemple : $reparation->technicien->nom
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technicien()
    {
        // belongsTo signifie : cette réparation appartient à un technicien
        // La clé étrangère 'technicien_id' est automatiquement déduite
        return $this->belongsTo(Technicien::class);
    }
}
