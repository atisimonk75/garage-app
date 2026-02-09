<?php

namespace Tests\Unit;

use App\Models\Vehicule;
use App\Models\Reparation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests unitaires pour le modèle Vehicule
 * Vérifie : les attributs, les accessors (légendes), les relations
 */
class VehiculeTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicule_can_be_created(): void
    {
        // Tester la création d'un véhicule via create()
        $vehicule = Vehicule::create([
            'immatriculation' => 'AB-123-CD',
            'marque' => 'Peugeot',
            'modele' => '3008',
            'energie' => 'D',
            'boite' => 'A',
        ]);

        $this->assertDatabaseHas('vehicules', [
            'id' => $vehicule->id,
            'immatriculation' => 'AB-123-CD',
            'marque' => 'Peugeot',
            'energie' => 'D',
        ]);
    }

    public function test_energie_label_accessor(): void
    {
        // Tester l'accessor energie_label
        $vehicule = Vehicule::create([
            'immatriculation' => 'AB-124-CD',
            'marque' => 'Renault',
            'modele' => 'Scenic',
            'energie' => 'E',
        ]);

        $this->assertEquals('Essence', $vehicule->energie_label);
    }

    public function test_energie_labels_all_codes(): void
    {
        // Tester tous les codes d'énergie disponibles
        $codes = [
            'E' => 'Essence',
            'D' => 'Diesel',
            'EL' => 'Électrique',
        ];

        foreach ($codes as $code => $label) {
            $v = Vehicule::create([
                'immatriculation' => "TEST-{$code}-" . rand(1000, 9999),
                'marque' => 'Test',
                'modele' => 'Test',
                'energie' => $code,
            ]);

            $this->assertEquals($label, $v->energie_label);
        }
    }

    public function test_boite_label_accessor(): void
    {
        // Tester l'accessor boite_label
        $vehicule = Vehicule::create([
            'immatriculation' => 'AB-125-CD',
            'marque' => 'Ford',
            'modele' => 'Focus',
            'boite' => 'M',
        ]);

        $this->assertEquals('Manuelle', $vehicule->boite_label);
    }

    public function test_boite_labels_all_codes(): void
    {
        // Tester tous les codes de boîte disponibles
        $codes = [
            'M' => 'Manuelle',
            'A' => 'Automatique',
        ];

        foreach ($codes as $code => $label) {
            $v = Vehicule::create([
                'immatriculation' => "BOITE-{$code}-" . rand(1000, 9999),
                'marque' => 'Test',
                'modele' => 'Test',
                'boite' => $code,
            ]);

            $this->assertEquals($label, $v->boite_label);
        }
    }

    public function test_vehicule_has_many_reparations(): void
    {
        // Tester la relation hasMany : un véhicule a plusieurs réparations
        $vehicule = Vehicule::factory()->create();
        Reparation::factory()->count(3)->create(['vehicule_id' => $vehicule->id]);

        $this->assertCount(3, $vehicule->reparations);
        $this->assertTrue($vehicule->reparations->every(fn($r) => $r->vehicule_id === $vehicule->id));
    }

    public function test_immatriculation_is_unique(): void
    {
        // Tester l'unicité de l'immatriculation
        $vehicule1 = Vehicule::create([
            'immatriculation' => 'UNIQUE-001',
            'marque' => 'Test1',
            'modele' => 'Model1',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Vehicule::create([
            'immatriculation' => 'UNIQUE-001',
            'marque' => 'Test2',
            'modele' => 'Model2',
        ]);
    }

    public function test_fillable_attributes(): void
    {
        // Vérifier que les champs fillable sont bien configurés
        $vehicule = new Vehicule();
        $expectedFillable = [
            'immatriculation',
            'marque',
            'modele',
            'couleur',
            'annee',
            'kilometrage',
            'carrosserie',
            'energie',
            'boite',
            'nombre_portes',
            'nombre_places',
            'prix_journalier'
        ];

        foreach ($expectedFillable as $field) {
            $this->assertContains($field, $vehicule->getFillable());
        }
    }

    public function test_accessors_are_appended(): void
    {
        // Vérifier que les accessors sont dans la liste des appends
        $vehicule = Vehicule::create([
            'immatriculation' => 'APPEND-001',
            'marque' => 'Test',
            'modele' => 'Test',
            'energie' => 'D',
            'boite' => 'A',
        ]);

        // Les accessors doivent être présents dans toArray()
        $array = $vehicule->toArray();
        $this->assertArrayHasKey('energie_label', $array);
        $this->assertArrayHasKey('boite_label', $array);
        $this->assertEquals('Diesel', $array['energie_label']);
        $this->assertEquals('Automatique', $array['boite_label']);
    }
}
