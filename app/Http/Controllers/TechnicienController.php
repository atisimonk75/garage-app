<?php
/**
 * ============================================================================
 * CONTRÔLEUR DES TECHNICIENS (TechnicienController)
 * ============================================================================
 * 
 * Ce contrôleur gère toutes les opérations CRUD pour les techniciens du garage :
 * - Lister tous les techniciens
 * - Créer un nouveau technicien
 * - Afficher les détails d'un technicien
 * - Modifier un technicien existant
 * - Supprimer un technicien
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;  // Contrôleur de base Laravel
use Illuminate\Http\Request;          // Classe pour gérer les requêtes HTTP

class TechnicienController extends Controller
{
    /**
     * ========================================================================
     * LISTER TOUS LES TECHNICIENS (INDEX)
     * ========================================================================
     * 
     * Récupère tous les techniciens de la base de données
     * et les affiche dans une vue.
     * 
     * @return \Illuminate\View\View  Vue avec la liste des techniciens
     */
    public function index()
    {
        // Récupérer tous les techniciens de la base de données
        // all() exécute : SELECT * FROM techniciens
        $techniciens = \App\Models\Technicien::all();
        
        // Retourner la vue avec les techniciens
        return view('techniciens.index', compact('techniciens'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE CRÉATION (CREATE)
     * ========================================================================
     * 
     * Affiche le formulaire vide pour ajouter un nouveau technicien.
     * 
     * @return \Illuminate\View\View  Vue contenant le formulaire
     */
    public function create()
    {
        return view('techniciens.create');
    }

    /**
     * ========================================================================
     * ENREGISTRER UN NOUVEAU TECHNICIEN (STORE)
     * ========================================================================
     * 
     * Traite le formulaire de création et enregistre le technicien.
     * 
     * @param  Request $request  Les données du formulaire
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            // Nom : obligatoire, texte, maximum 255 caractères
            'nom' => 'required|string|max:255',
            // Prénom : obligatoire, texte, maximum 255 caractères
            'prenom' => 'required|string|max:255',
            // Spécialité : optionnel (ex: mécanique, électricité, carrosserie)
            'specialite' => 'nullable|string|max:255',
        ]);

        // Créer le technicien avec les données validées
        \App\Models\Technicien::create($validated);

        // Rediriger vers la liste avec message de succès
        return redirect()->route('techniciens.index')->with('success', 'Technicien ajouté avec succès.');
    }

    /**
     * ========================================================================
     * AFFICHER LES DÉTAILS D'UN TECHNICIEN (SHOW)
     * ========================================================================
     * 
     * Affiche toutes les informations d'un technicien spécifique.
     * 
     * @param  string $id  L'identifiant du technicien
     * @return \Illuminate\View\View  Vue avec les détails
     */
    public function show(string $id)
    {
        // Chercher le technicien ou retourner erreur 404
        $technicien = \App\Models\Technicien::findOrFail($id);
        
        return view('techniciens.show', compact('technicien'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE MODIFICATION (EDIT)
     * ========================================================================
     * 
     * Affiche le formulaire pré-rempli pour modifier un technicien.
     * 
     * @param  string $id  L'identifiant du technicien à modifier
     * @return \Illuminate\View\View  Vue avec le formulaire
     */
    public function edit(string $id)
    {
        // Récupérer le technicien à modifier
        $technicien = \App\Models\Technicien::findOrFail($id);
        
        return view('techniciens.edit', compact('technicien'));
    }

    /**
     * ========================================================================
     * METTRE À JOUR UN TECHNICIEN (UPDATE)
     * ========================================================================
     * 
     * Traite le formulaire de modification et met à jour le technicien.
     * 
     * @param  Request $request  Les nouvelles données
     * @param  string $id  L'identifiant du technicien
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function update(Request $request, string $id)
    {
        // Récupérer le technicien à modifier
        $technicien = \App\Models\Technicien::findOrFail($id);

        // Valider les nouvelles données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'specialite' => 'nullable|string|max:255',
        ]);

        // Appliquer les modifications
        $technicien->update($validated);

        return redirect()->route('techniciens.index')->with('success', 'Technicien mis à jour avec succès.');
    }

    /**
     * ========================================================================
     * SUPPRIMER UN TECHNICIEN (DESTROY)
     * ========================================================================
     * 
     * Supprime définitivement un technicien de la base de données.
     * 
     * @param  string $id  L'identifiant du technicien à supprimer
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function destroy(string $id)
    {
        // Récupérer le technicien à supprimer
        $technicien = \App\Models\Technicien::findOrFail($id);
        
        // Supprimer le technicien
        $technicien->delete();

        return redirect()->route('techniciens.index')->with('success', 'Technicien supprimé avec succès.');
    }
}