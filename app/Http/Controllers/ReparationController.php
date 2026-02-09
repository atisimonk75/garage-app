<?php
/**
 * ============================================================================
 * CONTRÔLEUR DES RÉPARATIONS (ReparationController)
 * ============================================================================
 * 
 * Ce contrôleur gère toutes les opérations CRUD pour les réparations :
 * - Lister toutes les réparations avec leurs véhicules et techniciens
 * - Créer une nouvelle réparation
 * - Afficher les détails d'une réparation
 * - Modifier une réparation existante
 * - Supprimer une réparation
 * 
 * Une réparation lie un véhicule à un technicien avec une date et une description.
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;  // Contrôleur de base Laravel
use Illuminate\Http\Request;          // Classe pour gérer les requêtes HTTP

class ReparationController extends Controller
{
    /**
     * ========================================================================
     * LISTER TOUTES LES RÉPARATIONS (INDEX)
     * ========================================================================
     * 
     * Récupère toutes les réparations avec leurs relations (véhicule et technicien)
     * triées par date décroissante (plus récentes en premier).
     * 
     * @return \Illuminate\View\View  Vue avec la liste des réparations
     */
    public function index()
    {
        // Récupérer toutes les réparations avec eager loading
        // - with(['vehicule', 'technicien']) : Charge les relations en une seule requête
        //   Cela évite le problème N+1 (une requête par réparation pour chaque relation)
        // - orderBy('date', 'desc') : Trie par date décroissante
        $reparations = \App\Models\Reparation::with(['vehicule', 'technicien'])->orderBy('date', 'desc')->get();
        
        return view('reparations.index', compact('reparations'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE CRÉATION (CREATE)
     * ========================================================================
     * 
     * Affiche le formulaire pour créer une nouvelle réparation.
     * Charge également la liste des véhicules et techniciens pour les menus déroulants.
     * 
     * @return \Illuminate\View\View  Vue contenant le formulaire
     */
    public function create()
    {
        // Récupérer tous les véhicules pour le menu déroulant de sélection
        $vehicules = \App\Models\Vehicule::all();
        
        // Récupérer tous les techniciens pour le menu déroulant de sélection
        $techniciens = \App\Models\Technicien::all();
        
        // Passer les deux listes à la vue
        return view('reparations.create', compact('vehicules', 'techniciens'));
    }

    /**
     * ========================================================================
     * ENREGISTRER UNE NOUVELLE RÉPARATION (STORE)
     * ========================================================================
     * 
     * Traite le formulaire de création et enregistre la réparation.
     * 
     * @param  Request $request  Les données du formulaire
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            // ID du véhicule : obligatoire et doit exister dans la table vehicules
            'vehicule_id' => 'required|exists:vehicules,id',
            // ID du technicien : optionnel mais doit exister s'il est fourni
            'technicien_id' => 'nullable|exists:techniciens,id',
            // Date de la réparation : obligatoire et doit être une date valide
            'date' => 'required|date',
            // Durée de main d'œuvre en heures : optionnel, entier positif
            'duree_main_oeuvre' => 'nullable|integer|min:0',
            // Description de la réparation : obligatoire
            'objet_reparation' => 'required|string',
        ]);

        // Créer la réparation avec les données validées
        \App\Models\Reparation::create($validated);

        return redirect()->route('reparations.index')->with('success', 'Réparation enregistrée avec succès.');
    }

    /**
     * ========================================================================
     * AFFICHER LES DÉTAILS D'UNE RÉPARATION (SHOW)
     * ========================================================================
     * 
     * Affiche toutes les informations d'une réparation avec son véhicule
     * et son technicien associés.
     * 
     * @param  string $id  L'identifiant de la réparation
     * @return \Illuminate\View\View  Vue avec les détails
     */
    public function show(string $id)
    {
        // Récupérer la réparation avec ses relations
        // with(['vehicule', 'technicien']) charge les données associées
        $reparation = \App\Models\Reparation::with(['vehicule', 'technicien'])->findOrFail($id);
        
        return view('reparations.show', compact('reparation'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE MODIFICATION (EDIT)
     * ========================================================================
     * 
     * Affiche le formulaire pré-rempli pour modifier une réparation.
     * Charge également les listes de véhicules et techniciens.
     * 
     * @param  string $id  L'identifiant de la réparation à modifier
     * @return \Illuminate\View\View  Vue avec le formulaire
     */
    public function edit(string $id)
    {
        // Récupérer la réparation à modifier
        $reparation = \App\Models\Reparation::findOrFail($id);
        
        // Récupérer les véhicules et techniciens pour les menus déroulants
        $vehicules = \App\Models\Vehicule::all();
        $techniciens = \App\Models\Technicien::all();
        
        return view('reparations.edit', compact('reparation', 'vehicules', 'techniciens'));
    }

    /**
     * ========================================================================
     * METTRE À JOUR UNE RÉPARATION (UPDATE)
     * ========================================================================
     * 
     * Traite le formulaire de modification et met à jour la réparation.
     * 
     * @param  Request $request  Les nouvelles données
     * @param  string $id  L'identifiant de la réparation
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function update(Request $request, string $id)
    {
        // Récupérer la réparation à modifier
        $reparation = \App\Models\Reparation::findOrFail($id);

        // Valider les nouvelles données (mêmes règles que store)
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'technicien_id' => 'nullable|exists:techniciens,id',
            'date' => 'required|date',
            'duree_main_oeuvre' => 'nullable|integer|min:0',
            'objet_reparation' => 'required|string',
        ]);

        // Appliquer les modifications
        $reparation->update($validated);

        return redirect()->route('reparations.index')->with('success', 'Réparation mise à jour avec succès.');
    }

    /**
     * ========================================================================
     * SUPPRIMER UNE RÉPARATION (DESTROY)
     * ========================================================================
     * 
     * Supprime définitivement une réparation de la base de données.
     * 
     * @param  string $id  L'identifiant de la réparation à supprimer
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function destroy(string $id)
    {
        // Récupérer la réparation à supprimer
        $reparation = \App\Models\Reparation::findOrFail($id);
        
        // Supprimer la réparation
        $reparation->delete();

        return redirect()->route('reparations.index')->with('success', 'Réparation supprimée avec succès.');
    }
}