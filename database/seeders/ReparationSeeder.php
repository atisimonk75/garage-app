<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Reparation;
use App\Models\Technicien;
use App\Models\Vehicule;

use function Symfony\Component\Clock\now;

class ReparationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicules = Vehicule::first();
        $technicien = Technicien::first();

        if ($vehicules && $technicien) {
            Reparation::create([
                "vehicule_id" => $vehicules->id,
                "technicien_id" => $technicien->id,
                "date" => now(),
                "duree_main_oeuvre" => 45,
                "objet_reparation" => "Remplacement des plaquettes de frein",
            ]);
        }
    }
}
