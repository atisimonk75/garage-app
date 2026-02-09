<?php
/**
 * ============================================================================
 * MODÈLE VEHICULE
 * ============================================================================
 * 
 * Ce modèle représente la table 'vehicules' dans la base de données.
 * Il gère toutes les informations relatives aux véhicules du garage :
 * immatriculation, marque, modèle, caractéristiques techniques, etc.
 * 
 * Table : vehicules
 * 
 * Relations :
 * - Un véhicule peut avoir plusieurs réparations (hasMany)
 * 
 * @package App\Models
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;                    // Classe de base Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;     // Trait pour les factories

class Vehicule extends Model
{
    /**
     * Trait HasFactory : Permet d'utiliser les factories pour créer
     * des véhicules de test dans les tests unitaires
     */
    use HasFactory;

    /**
     * ========================================================================
     * LÉGENDES DES CODES
     * ========================================================================
     * 
     * Certains champs utilisent des codes courts pour économiser de l'espace :
     * 
     * Énergie (energie) :
     *   - 'E'  => 'Essence'
     *   - 'D'  => 'Diesel'
     *   - 'EL' => 'Électrique'
     * 
     * Boîte de vitesses (boite) :
     *   - 'M' => 'Manuelle'
     *   - 'A' => 'Automatique'
     */

    /**
     * ========================================================================
     * ATTRIBUTS REMPLISSABLES (Mass Assignment)
     * ========================================================================
     * 
     * Liste des champs qui peuvent être assignés en masse.
     * Protection contre les attaques d'assignation malveillante.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'immatriculation',   // Numéro d'immatriculation unique (ex: AB-123-CD)
        'marque',            // Marque du véhicule (ex: Peugeot, Renault)
        'modele',            // Modèle du véhicule (ex: 308, Clio)
        'couleur',           // Couleur du véhicule
        'annee',             // Année de fabrication
        'kilometrage',       // Kilométrage actuel
        'carrosserie',       // Type de carrosserie (berline, SUV, etc.)
        'energie',           // Type d'énergie : E, D, ou EL
        'boite',             // Type de boîte : M ou A
        'nombre_portes',     // Nombre de portes
        'nombre_places',     // Nombre de places assises
        'prix_journalier'    // Prix de location journalier (si applicable)
    ];

    /**
     * ========================================================================
     * TABLEAUX DE LÉGENDES STATIQUES
     * ========================================================================
     * 
     * Ces tableaux permettent de convertir les codes en libellés lisibles.
     * Ils sont statiques pour pouvoir être utilisés sans instancier le modèle.
     * 
     * Utilisation dans les vues : Vehicule::$energieLegend['E'] => 'Essence'
     */
    
    /**
     * Légende des types d'énergie
     * @var array<string, string>
     */
    public static $energieLegend = [
        'E' => 'Essence',
        'D' => 'Diesel',
        'EL' => 'Électrique',
    ];

    /**
     * Légende des types de boîte de vitesses
     * @var array<string, string>
     */
    public static $boiteLegend = [
        'M' => 'Manuelle',
        'A' => 'Automatique',
    ];

    /**
     * ========================================================================
     * ATTRIBUTS AJOUTÉS (Appends)
     * ========================================================================
     * 
     * Ces attributs virtuels sont automatiquement ajoutés lors de la
     * sérialisation du modèle (toArray(), toJson()).
     * Ils n'existent pas en base de données mais sont calculés à la volée.
     * 
     * @var array<string>
     */
    protected $appends = ['energie_label', 'boite_label'];

    /**
     * ========================================================================
     * ACCESSEUR : Libellé de l'énergie
     * ========================================================================
     * 
     * Cet accesseur convertit le code énergie en libellé lisible.
     * Appelé automatiquement quand on accède à $vehicule->energie_label
     * 
     * @return string  Le libellé de l'énergie (ex: 'Essence')
     */
    public function getEnergieLabelAttribute()
    {
        // Retourne le libellé correspondant au code, ou le code lui-même si inconnu
        return self::$energieLegend[$this->energie] ?? $this->energie;
    }

    /**
     * ========================================================================
     * ACCESSEUR : Libellé de la boîte de vitesses
     * ========================================================================
     * 
     * Cet accesseur convertit le code boîte en libellé lisible.
     * Appelé automatiquement quand on accède à $vehicule->boite_label
     * 
     * @return string  Le libellé de la boîte (ex: 'Automatique')
     */
    public function getBoiteLabelAttribute()
    {
        return self::$boiteLegend[$this->boite] ?? $this->boite;
    }

    /**
     * ========================================================================
     * RELATION : Réparations du véhicule
     * ========================================================================
     * 
     * Un véhicule peut avoir plusieurs réparations (relation One-to-Many).
     * Cette méthode permet d'accéder à toutes les réparations d'un véhicule.
     * 
     * Utilisation : $vehicule->reparations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reparations()
    {
        // hasMany signifie : ce véhicule possède plusieurs réparations
        // La clé étrangère 'vehicule_id' est automatiquement déduite
        return $this->hasMany(Reparation::class);
    }
}