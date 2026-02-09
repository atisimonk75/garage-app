<?php

namespace Tests\Feature;

use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests Feature pour VehiculeController
 * Teste tous les CRUD operations et la validation
 */
class VehiculeControllerTest extends TestCase
{
    use RefreshDatabase;

    // === INDEX TESTS ===

    public function test_index_returns_list_of_vehicules(): void
    {
        // Créer quelques véhicules
        Vehicule::factory()->count(5)->create();

        $response = $this->get(route('vehicules.index'));

        $response->assertStatus(200);
        $response->assertViewHas('vehicules');
        $this->assertCount(5, $response['vehicules']);
    }

    public function test_index_search_by_immatriculation(): void
    {
        // Tester la recherche par immatriculation
        $vehicule = Vehicule::create([
            'immatriculation' => 'SEARCH-001',
            'marque' => 'Test',
            'modele' => 'Test',
        ]);

        Vehicule::factory()->count(3)->create();

        $response = $this->get(route('vehicules.index') . '?search=SEARCH-001');

        $response->assertStatus(200);
        $this->assertCount(1, $response['vehicules']);
        $this->assertEquals('SEARCH-001', $response['vehicules'][0]->immatriculation);
    }

    public function test_index_search_by_marque(): void
    {
        // Tester la recherche par marque
        Vehicule::create([
            'immatriculation' => 'AB-001-CD',
            'marque' => 'Toyota',
            'modele' => 'Corolla',
        ]);

        Vehicule::factory()->count(2)->create();

        $response = $this->get(route('vehicules.index') . '?search=Toyota');

        $response->assertStatus(200);
        $this->assertCount(1, $response['vehicules']);
    }

    // === CREATE TESTS ===

    public function test_create_returns_create_view(): void
    {
        // Tester que la page de création s'affiche
        $response = $this->get(route('vehicules.create'));

        $response->assertStatus(200);
        $response->assertViewIs('vehicules.create');
    }

    // === STORE TESTS ===

    public function test_store_creates_vehicule_with_valid_data(): void
    {
        // Tester la création d'un véhicule avec des données valides
        $data = [
            'immatriculation' => 'STORE-001',
            'marque' => 'Nissan',
            'modele' => 'Altima',
            'couleur' => 'Bleu',
            'annee' => 2023,
            'kilometrage' => 5000,
            'carrosserie' => 'Berline',
            'energie' => 'E',
            'boite' => 'A',
        ];

        $response = $this->post(route('vehicules.store'), $data);

        $response->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseHas('vehicules', [
            'immatriculation' => 'STORE-001',
            'marque' => 'Nissan',
        ]);
    }

    public function test_store_validates_immatriculation_required(): void
    {
        // Immatriculation est requis
        $response = $this->post(route('vehicules.store'), [
            'marque' => 'Test',
            'modele' => 'Test',
        ]);

        $response->assertSessionHasErrors('immatriculation');
        $this->assertDatabaseCount('vehicules', 0);
    }

    public function test_store_validates_immatriculation_unique(): void
    {
        // Immatriculation doit être unique
        Vehicule::create([
            'immatriculation' => 'UNIQUE-001',
            'marque' => 'Test',
            'modele' => 'Test',
        ]);

        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'UNIQUE-001',
            'marque' => 'Test2',
            'modele' => 'Test2',
        ]);

        $response->assertSessionHasErrors('immatriculation');
    }

    public function test_store_validates_immatriculation_max_length(): void
    {
        // Immatriculation max 20 caractères
        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => str_repeat('A', 21),
            'marque' => 'Test',
            'modele' => 'Test',
        ]);

        $response->assertSessionHasErrors('immatriculation');
    }

    public function test_store_validates_marque_required(): void
    {
        // Marque est requis
        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'TEST-001',
            'modele' => 'Test',
        ]);

        $response->assertSessionHasErrors('marque');
    }

    public function test_store_validates_modele_required(): void
    {
        // Modèle est requis
        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'TEST-001',
            'marque' => 'Test',
        ]);

        $response->assertSessionHasErrors('modele');
    }

    public function test_store_validates_annee_min_max(): void
    {
        // Année doit être entre 1900 et l'année prochaine
        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'ANNEE-001',
            'marque' => 'Test',
            'modele' => 'Test',
            'annee' => 1899,
        ]);

        $response->assertSessionHasErrors('annee');

        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'ANNEE-002',
            'marque' => 'Test',
            'modele' => 'Test',
            'annee' => date('Y') + 2,
        ]);

        $response->assertSessionHasErrors('annee');
    }

    public function test_store_validates_kilometrage_positive(): void
    {
        // Kilométrage doit être >= 0
        $response = $this->post(route('vehicules.store'), [
            'immatriculation' => 'KM-001',
            'marque' => 'Test',
            'modele' => 'Test',
            'kilometrage' => -100,
        ]);

        $response->assertSessionHasErrors('kilometrage');
    }

    // === SHOW TESTS ===

    public function test_show_displays_vehicule(): void
    {
        // Tester l'affichage des détails d'un véhicule
        $vehicule = Vehicule::factory()->create();

        $response = $this->get(route('vehicules.show', $vehicule));

        $response->assertStatus(200);
        $response->assertViewHas('vehicule', $vehicule);
    }

    public function test_show_returns_404_for_nonexistent_vehicule(): void
    {
        // Tester que 404 est retourné pour un véhicule inexistant
        $response = $this->get(route('vehicules.show', 99999));

        $response->assertNotFound();
    }

    // === EDIT TESTS ===

    public function test_edit_returns_edit_view(): void
    {
        // Tester que la page d'édition s'affiche
        $vehicule = Vehicule::factory()->create();

        $response = $this->get(route('vehicules.edit', $vehicule));

        $response->assertStatus(200);
        $response->assertViewHas('vehicule', $vehicule);
    }

    public function test_edit_returns_404_for_nonexistent_vehicule(): void
    {
        // Tester que 404 est retourné pour un véhicule inexistant
        $response = $this->get(route('vehicules.edit', 99999));

        $response->assertNotFound();
    }

    // === UPDATE TESTS ===

    public function test_update_modifies_vehicule(): void
    {
        // Tester la modification d'un véhicule
        $vehicule = Vehicule::factory()->create([
            'marque' => 'Ancienne',
        ]);

        $response = $this->put(route('vehicules.update', $vehicule), [
            'immatriculation' => $vehicule->immatriculation,
            'marque' => 'Nouvelle',
            'modele' => $vehicule->modele,
        ]);

        $response->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseHas('vehicules', [
            'id' => $vehicule->id,
            'marque' => 'Nouvelle',
        ]);
    }

    public function test_update_allows_same_immatriculation(): void
    {
        // Vérifier que l'immatriculation actuelle est acceptée en update
        $vehicule = Vehicule::factory()->create();
        $originalImmaculation = $vehicule->immatriculation;

        $response = $this->put(route('vehicules.update', $vehicule), [
            'immatriculation' => $originalImmaculation,
            'marque' => 'Updated',
            'modele' => 'Updated',
        ]);

        $response->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseHas('vehicules', [
            'id' => $vehicule->id,
            'marque' => 'Updated',
        ]);
    }

    public function test_update_prevents_duplicate_immatriculation(): void
    {
        // Tester que deux véhicules ne peuvent pas avoir la même immatriculation
        $v1 = Vehicule::factory()->create(['immatriculation' => 'UNIQUE-V1']);
        $v2 = Vehicule::factory()->create(['immatriculation' => 'UNIQUE-V2']);

        $response = $this->put(route('vehicules.update', $v2), [
            'immatriculation' => 'UNIQUE-V1',
            'marque' => $v2->marque,
            'modele' => $v2->modele,
        ]);

        $response->assertSessionHasErrors('immatriculation');
    }

    public function test_update_returns_404_for_nonexistent_vehicule(): void
    {
        // Tester que 404 est retourné pour un véhicule inexistant
        $response = $this->put(route('vehicules.update', 99999), [
            'immatriculation' => 'TEST-001',
            'marque' => 'Test',
            'modele' => 'Test',
        ]);

        $response->assertNotFound();
    }

    // === DESTROY TESTS ===

    public function test_destroy_deletes_vehicule(): void
    {
        // Tester la suppression d'un véhicule
        $vehicule = Vehicule::factory()->create();
        $vehiculeId = $vehicule->id;

        $response = $this->delete(route('vehicules.destroy', $vehicule));

        $response->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseMissing('vehicules', ['id' => $vehiculeId]);
    }

    public function test_destroy_returns_404_for_nonexistent_vehicule(): void
    {
        // Tester que 404 est retourné pour un véhicule inexistant
        $response = $this->delete(route('vehicules.destroy', 99999));

        $response->assertNotFound();
    }

    public function test_destroy_cascades_delete_reparations(): void
    {
        // Tester que supprimer un véhicule supprime aussi ses réparations
        $vehicule = Vehicule::factory()->create();
        \App\Models\Reparation::factory()->count(3)->create(['vehicule_id' => $vehicule->id]);

        $this->assertCount(3, \App\Models\Reparation::where('vehicule_id', $vehicule->id)->get());

        $this->delete(route('vehicules.destroy', $vehicule));

        $this->assertCount(0, \App\Models\Reparation::where('vehicule_id', $vehicule->id)->get());
    }
}
