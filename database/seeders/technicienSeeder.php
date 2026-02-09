<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technicien;

class technicienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technicien::create([
            "nom" => "Dupont",
            "prenom" => "Jean",
            "email" => "jean.dupont@example.com",
            "telephone" => "0612345678",
            "specialite" => "Mécanique"
        ]);
        Technicien::create([
            "nom" => "Martin",
            "prenom" => "Sophie",
            "email" => "sophie.martin@example.com",
            "telephone" => "0698765432",
            "specialite" => "Electrique"
        ]);

        Technicien::create([
            "nom" => "Bernard",
            "prenom" => "Luc",
            "email" => "luc.bernard@example.com",
            "telephone" => "065 4321876",
            "specialite" => "Carrosserie"
        ]);
        Technicien::create
        ([
            "nom" => "Durand",
            "prenom" => "Claire",
            "email" => "claire.durand@example.com",
            "telephone" => "0612345678",
            "specialite" => "Mécanique"
        ]);

    }
}
