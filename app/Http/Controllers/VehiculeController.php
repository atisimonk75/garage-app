<?php
/**
 * ============================================================================
 * CONTRÔLEUR DES VÉHICULES (VehiculeController)
 * ============================================================================
 * 
 * Ce contrôleur gère toutes les opérations CRUD (Create, Read, Update, Delete)
 * pour les véhicules du garage. Il permet de :
 * - Lister tous les véhicules avec recherche
 * - Créer un nouveau véhicule
 * - Afficher les détails d'un véhicule
 * - Modifier un véhicule existant
 * - Supprimer un véhicule
 * 
 * @package App\Http\Controllers
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // Classe pour gérer les requêtes HTTP

class VehiculeController extends Controller
{
    /**
     * ========================================================================
     * LISTER TOUS LES VÉHICULES (INDEX)
     * ========================================================================
     * 
     * Affiche la liste de tous les véhicules avec possibilité de recherche
     * par immatriculation ou marque.
     * 
     * @param  Request $request  La requête HTTP (peut contenir un paramètre 'search')
     * @return \Illuminate\View\View  Vue avec la liste des véhicules
     */
    public function index(Request $request)
    {
        // Créer une requête de base sur le modèle Vehicule
        // query() permet de construire une requête progressivement
        $query = \App\Models\Vehicule::query();

        // Vérifier si l'utilisateur a saisi un terme de recherche
        if ($search = $request->input('search')) {
            // Ajouter des conditions de recherche :
            // - WHERE immatriculation LIKE '%search%'
            // - OR marque LIKE '%search%'
            // Le % permet de chercher le terme n'importe où dans la chaîne
            $query->where('immatriculation', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%");
        }

        // Exécuter la requête et récupérer tous les résultats
        $vehicules = $query->get();
        
        // Retourner la vue avec les véhicules
        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE CRÉATION (CREATE)
     * ========================================================================
     * 
     * Affiche le formulaire vide pour ajouter un nouveau véhicule.
     * 
     * @return \Illuminate\View\View  Vue contenant le formulaire de création
     */
    public function create()
    {
        return view('vehicules.create');
    }

    /**
     * ========================================================================
     * ENREGISTRER UN NOUVEAU VÉHICULE (STORE)
     * ========================================================================
     * 
     * Traite le formulaire de création et enregistre le véhicule en base.
     * 
     * @param  Request $request  Les données du formulaire
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire avec des règles précises
        $validated = $request->validate([
            // Immatriculation : obligatoire, unique dans la table, max 20 caractères
            'immatriculation' => 'required|unique:vehicules|max:20',
            // Marque : obligatoire, texte, max 20 caractères
            'marque' => 'required|string|max:20',
            // Modèle : obligatoire, texte, max 20 caractères
            'modele' => 'required|string|max:20',
            // Couleur : optionnel, texte, max 20 caractères
            'couleur' => 'nullable|string|max:20',
            // Année : optionnel, entier entre 2000 et année suivante
            'annee' => 'nullable|integer|min:2000|max:'.(date('Y')+1),
            // Kilométrage : optionnel, entier positif
            'kilometrage' => 'nullable|integer|min:0',
            // Carrosserie, énergie, boîte : optionnels
            'carrosserie' => 'nullable|string',
            'energie' => 'nullable|string',
            'boite' => 'nullable|string',
        ]);

        // Créer le véhicule avec les données validées
        // Mass assignment : toutes les données validées sont insérées d'un coup
        \App\Models\Vehicule::create($validated);

        // Rediriger vers la liste avec un message de succès
        // Le message sera accessible via session('success') dans la vue
        return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté avec succès.');
    }

    /**
     * ========================================================================
     * AFFICHER LES DÉTAILS D'UN VÉHICULE (SHOW)
     * ========================================================================
     * 
     * Affiche toutes les informations d'un véhicule spécifique.
     * 
     * @param  string $id  L'identifiant du véhicule
     * @return \Illuminate\View\View  Vue avec les détails du véhicule
     */
    public function show(string $id)
    {
        // Chercher le véhicule par son ID
        // findOrFail() lève une exception 404 si le véhicule n'existe pas
        $vehicule = \App\Models\Vehicule::findOrFail($id);
        
        return view('vehicules.show', compact('vehicule'));
    }

    /**
     * ========================================================================
     * AFFICHER LE FORMULAIRE DE MODIFICATION (EDIT)
     * ========================================================================
     * 
     * Affiche le formulaire pré-rempli pour modifier un véhicule.
     * 
     * @param  string $id  L'identifiant du véhicule à modifier
     * @return \Illuminate\View\View  Vue avec le formulaire de modification
     */
    public function edit(string $id)
    {
        // Récupérer le véhicule à modifier
        $vehicule = \App\Models\Vehicule::findOrFail($id);
        
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * ========================================================================
     * METTRE À JOUR UN VÉHICULE (UPDATE)
     * ========================================================================
     * 
     * Traite le formulaire de modification et met à jour le véhicule.
     * 
     * @param  Request $request  Les nouvelles données du formulaire
     * @param  string $id  L'identifiant du véhicule à modifier
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function update(Request $request, string $id)
    {
        // Récupérer le véhicule à modifier
        $vehicule = \App\Models\Vehicule::findOrFail($id);

        // Valider les données avec une exception pour l'unicité
        // 'unique:vehicules,immatriculation,'.$vehicule->id ignore le véhicule actuel
        // Cela permet de garder la même immatriculation lors de la modification
        $validated = $request->validate([
            'immatriculation' => 'required|max:20|unique:vehicules,immatriculation,'.$vehicule->id,
            'marque' => 'required|string',
            'modele' => 'required|string',
            'couleur' => 'nullable|string',
            'annee' => 'nullable|integer|min:1900|max:'.(date('Y')+1),
            'kilometrage' => 'nullable|integer|min:0',
            'carrosserie' => 'nullable|string',
            'energie' => 'nullable|string',
            'boite' => 'nullable|string',
        ]);

        // Mettre à jour le véhicule avec les nouvelles données
        $vehicule->update($validated);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule mis à jour avec succès.');
    }

    /**
     * ========================================================================
     * SUPPRIMER UN VÉHICULE (DESTROY)
     * ========================================================================
     * 
     * Supprime définitivement un véhicule de la base de données.
     * 
     * @param  string $id  L'identifiant du véhicule à supprimer
     * @return \Illuminate\Http\RedirectResponse  Redirection vers la liste
     */
    public function destroy(string $id)
    {
        // Récupérer le véhicule à supprimer
        $vehicule = \App\Models\Vehicule::findOrFail($id);
        
        // Supprimer le véhicule de la base de données
        // Attention : cela supprime définitivement les données !
        $vehicule->delete();

        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
    }
}
