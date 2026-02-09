<?php

namespace Tests\Unit;

use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\Technicien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests unitaires pour le modèle Reparation
 * Vérifie : les attributs, les casts, les relations
 */
class ReparationTest extends TestCase
{
    use RefreshDatabase;

    public function test_reparation_can_be_created(): void
    {
        // Tester la création d'une réparation
        $vehicule = Vehicule::factory()->create();
        $technicien = Technicien::factory()->create();

        $reparation = Reparation::create([
            'vehicule_id' => $vehicule->id,
            'technicien_id' => $technicien->id,
            'date' => now(),
            'duree_main_oeuvre' => 120,
            'objet_reparation' => 'Remplacement des plaquettes de frein',
        ]);

        $this->assertDatabaseHas('reparations', [
            'id' => $reparation->id,
            'vehicule_id' => $vehicule->id,
            'duree_main_oeuvre' => 120,
        ]);
    }

    public function test_reparation_belongs_to_vehicule(): void
    {
        // Tester la relation belongsTo vers Vehicule
        $vehicule = Vehicule::factory()->create();
        $reparation = Reparation::factory()->create(['vehicule_id' => $vehicule->id]);

        $this->assertTrue($reparation->vehicule()->exists());
        $this->assertEquals($vehicule->id, $reparation->vehicule->id);
    }

    public function test_reparation_belongs_to_technicien(): void
    {
        // Tester la relation belongsTo vers Technicien (nullable)
        $technicien = Technicien::factory()->create();
        $reparation = Reparation::factory()->create(['technicien_id' => $technicien->id]);

        $this->assertTrue($reparation->technicien()->exists());
        $this->assertEquals($technicien->id, $reparation->technicien->id);
    }

    public function test_reparation_technicien_is_nullable(): void
    {
        // Vérifier que technicien_id peut être null
        $vehicule = Vehicule::factory()->create();
        $reparation = Reparation::create([
            'vehicule_id' => $vehicule->id,
            'technicien_id' => null,
            'date' => now(),
            'objet_reparation' => 'Diagnostic',
        ]);

        $this->assertNull($reparation->technicien_id);
    }

    public function test_date_is_cast_to_date(): void
    {
        // Vérifier que le cast 'date' fonctionne
        $vehicule = Vehicule::factory()->create();
        $dateString = '2026-02-03';

        $reparation = Reparation::create([
            'vehicule_id' => $vehicule->id,
            'date' => $dateString,
            'objet_reparation' => 'Test date cast',
        ]);

        // La date doit être une instance de Carbon
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $reparation->date);
        $this->assertEquals('2026-02-03', $reparation->date->format('Y-m-d'));
    }

    public function test_fillable_attributes(): void
    {
        // Vérifier que les champs fillable sont bien configurés
        $reparation = new Reparation();
        $expectedFillable = [
            'vehicule_id',
            'technicien_id',
            'date',
            'duree_main_oeuvre',
            'objet_reparation'
        ];

        foreach ($expectedFillable as $field) {
            $this->assertContains($field, $reparation->getFillable());
        }
    }

    public function test_reparation_with_vehicule_cascade_delete(): void
    {
        // Vérifier que supprimer un véhicule supprime aussi ses réparations (cascade)
        $vehicule = Vehicule::factory()->create();
        $reparation = Reparation::factory()->create(['vehicule_id' => $vehicule->id]);

        $reparationId = $reparation->id;
        $vehicule->delete();

        // La réparation doit être supprimée aussi
        $this->assertDatabaseMissing('reparations', ['id' => $reparationId]);
    }
}
