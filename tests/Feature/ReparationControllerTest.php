<?php

namespace Tests\Feature;

use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\Technicien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests Feature pour ReparationController
 * Teste tous les CRUD operations et la validation
 */
class ReparationControllerTest extends TestCase
{
    use RefreshDatabase;

    // === INDEX TESTS ===

    public function test_index_returns_list_of_reparations(): void
    {
        // Créer quelques réparations
        Reparation::factory()->count(5)->create();

        $response = $this->get(route('reparations.index'));

        $response->assertStatus(200);
        $response->assertViewHas('reparations');
        $this->assertCount(5, $response['reparations']);
    }

    public function test_index_eager_loads_relations(): void
    {
        // Vérifier que les relations (vehicule, technicien) sont chargées
        Reparation::factory()->count(3)->create();

        $response = $this->get(route('reparations.index'));

        $response->assertStatus(200);
        // Vérifier que les relations existent
        $reparations = $response['reparations'];
        foreach ($reparations as $rep) {
            $this->assertNotNull($rep->vehicule);
        }
    }

    // === CREATE TESTS ===

    public function test_create_returns_create_view(): void
    {
        // Tester que la page de création s'affiche avec les listes
        $response = $this->get(route('reparations.create'));

        $response->assertStatus(200);
        $response->assertViewIs('reparations.create');
        $response->assertViewHas(['vehicules', 'techniciens']);
    }

    // === STORE TESTS ===

    public function test_store_creates_reparation_with_valid_data(): void
    {
        // Tester la création d'une réparation avec des données valides
        $vehicule = Vehicule::factory()->create();
        $technicien = Technicien::factory()->create();

        $data = [
            'vehicule_id' => $vehicule->id,
            'technicien_id' => $technicien->id,
            'date' => now()->toDateString(),
            'duree_main_oeuvre' => 120,
            'objet_reparation' => 'Remplacement des plaquettes de frein',
        ];

        $response = $this->post(route('reparations.store'), $data);

        $response->assertRedirect(route('reparations.index'));
        $this->assertDatabaseHas('reparations', [
            'vehicule_id' => $vehicule->id,
            'duree_main_oeuvre' => 120,
        ]);
    }

    public function test_store_creates_reparation_without_technicien(): void
    {
        // Tester que technicien_id est nullable
        $vehicule = Vehicule::factory()->create();

        $data = [
            'vehicule_id' => $vehicule->id,
            'date' => now()->toDateString(),
            'objet_reparation' => 'Diagnostic',
        ];

        $response = $this->post(route('reparations.store'), $data);

        $response->assertRedirect(route('reparations.index'));
        $this->assertDatabaseHas('reparations', [
            'vehicule_id' => $vehicule->id,
            'technicien_id' => null,
        ]);
    }

    public function test_store_validates_vehicule_id_required(): void
    {
        // vehicule_id est requis
        $response = $this->post(route('reparations.store'), [
            'date' => now()->toDateString(),
            'objet_reparation' => 'Test',
        ]);

        $response->assertSessionHasErrors('vehicule_id');
    }

    public function test_store_validates_vehicule_id_exists(): void
    {
        // vehicule_id doit référencer un véhicule existant
        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => 99999,
            'date' => now()->toDateString(),
            'objet_reparation' => 'Test',
        ]);

        $response->assertSessionHasErrors('vehicule_id');
    }

    public function test_store_validates_date_required(): void
    {
        // date est requis
        $vehicule = Vehicule::factory()->create();

        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => $vehicule->id,
            'objet_reparation' => 'Test',
        ]);

        $response->assertSessionHasErrors('date');
    }

    public function test_store_validates_date_format(): void
    {
        // date doit être au format date
        $vehicule = Vehicule::factory()->create();

        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => $vehicule->id,
            'date' => 'not-a-date',
            'objet_reparation' => 'Test',
        ]);

        $response->assertSessionHasErrors('date');
    }

    public function test_store_validates_objet_reparation_required(): void
    {
        // objet_reparation est requis
        $vehicule = Vehicule::factory()->create();

        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => $vehicule->id,
            'date' => now()->toDateString(),
        ]);

        $response->assertSessionHasErrors('objet_reparation');
    }

    public function test_store_validates_duree_positive(): void
    {
        // duree_main_oeuvre doit être >= 0 si fourni
        $vehicule = Vehicule::factory()->create();

        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => $vehicule->id,
            'date' => now()->toDateString(),
            'objet_reparation' => 'Test',
            'duree_main_oeuvre' => -10,
        ]);

        $response->assertSessionHasErrors('duree_main_oeuvre');
    }

    public function test_store_validates_technicien_id_exists(): void
    {
        // technicien_id doit référencer un technicien existant s'il est fourni
        $vehicule = Vehicule::factory()->create();

        $response = $this->post(route('reparations.store'), [
            'vehicule_id' => $vehicule->id,
            'date' => now()->toDateString(),
            'objet_reparation' => 'Test',
            'technicien_id' => 99999,
        ]);

        $response->assertSessionHasErrors('technicien_id');
    }

    // === SHOW TESTS ===

    public function test_show_displays_reparation(): void
    {
        // Tester l'affichage des détails d'une réparation
        $reparation = Reparation::factory()->create();

        $response = $this->get(route('reparations.show', $reparation));

        $response->assertStatus(200);
        $response->assertViewHas('reparation', $reparation);
    }

    public function test_show_returns_404_for_nonexistent_reparation(): void
    {
        // Tester que 404 est retourné pour une réparation inexistante
        $response = $this->get(route('reparations.show', 99999));

        $response->assertNotFound();
    }

    // === EDIT TESTS ===

    public function test_edit_returns_edit_view(): void
    {
        // Tester que la page d'édition s'affiche
        $reparation = Reparation::factory()->create();

        $response = $this->get(route('reparations.edit', $reparation));

        $response->assertStatus(200);
        $response->assertViewHas('reparation', $reparation);
        $response->assertViewHas(['vehicules', 'techniciens']);
    }

    public function test_edit_returns_404_for_nonexistent_reparation(): void
    {
        // Tester que 404 est retourné pour une réparation inexistante
        $response = $this->get(route('reparations.edit', 99999));

        $response->assertNotFound();
    }

    // === UPDATE TESTS ===

    public function test_update_modifies_reparation(): void
    {
        // Tester la modification d'une réparation
        $reparation = Reparation::factory()->create([
            'duree_main_oeuvre' => 60,
        ]);

        $response = $this->put(route('reparations.update', $reparation), [
            'vehicule_id' => $reparation->vehicule_id,
            'date' => $reparation->date,
            'objet_reparation' => 'Objet modifié',
            'duree_main_oeuvre' => 120,
        ]);

        $response->assertRedirect(route('reparations.index'));
        $this->assertDatabaseHas('reparations', [
            'id' => $reparation->id,
            'objet_reparation' => 'Objet modifié',
            'duree_main_oeuvre' => 120,
        ]);
    }

    public function test_update_can_assign_technicien(): void
    {
        // Tester l'assignation d'un technicien à une réparation sans technicien
        $reparation = Reparation::factory()->create(['technicien_id' => null]);
        $technicien = Technicien::factory()->create();

        $response = $this->put(route('reparations.update', $reparation), [
            'vehicule_id' => $reparation->vehicule_id,
            'date' => $reparation->date,
            'objet_reparation' => $reparation->objet_reparation,
            'technicien_id' => $technicien->id,
        ]);

        $response->assertRedirect(route('reparations.index'));
        $this->assertDatabaseHas('reparations', [
            'id' => $reparation->id,
            'technicien_id' => $technicien->id,
        ]);
    }

    public function test_update_returns_404_for_nonexistent_reparation(): void
    {
        // Tester que 404 est retourné pour une réparation inexistante
        $response = $this->put(route('reparations.update', 99999), [
            'vehicule_id' => 1,
            'date' => now()->toDateString(),
            'objet_reparation' => 'Test',
        ]);

        $response->assertNotFound();
    }

    // === DESTROY TESTS ===

    public function test_destroy_deletes_reparation(): void
    {
        // Tester la suppression d'une réparation
        $reparation = Reparation::factory()->create();
        $reparationId = $reparation->id;

        $response = $this->delete(route('reparations.destroy', $reparation));

        $response->assertRedirect(route('reparations.index'));
        $this->assertDatabaseMissing('reparations', ['id' => $reparationId]);
    }

    public function test_destroy_returns_404_for_nonexistent_reparation(): void
    {
        // Tester que 404 est retourné pour une réparation inexistante
        $response = $this->delete(route('reparations.destroy', 99999));

        $response->assertNotFound();
    }
}
