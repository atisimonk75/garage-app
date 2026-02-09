<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Vehicule;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicule::create([ 
            "immatriculation" => "AB-123-CD",
            "marque" => "Toyota",
            "modele" => "Corolla",
            "couleur" => "Bleu",
            "annee" => 2020,
            "kilometrage" => 15000,
            "energie" => "Essence",
            "boite" => "Manuelle",
            "nombre_portes" => 4,
            "nombre_places" => 5,
            "prix_journalier" => 45.99
        ]);
        Vehicule::create([ 
            "immatriculation" => "EF-456-GH",
            "marque" => "Honda",
            "modele" => "Civic",
            "couleur" => "Rouge",
            "annee" => 2019,
            "kilometrage" => 22000,
            "energie" => "Diesel",
            "boite" => "Automatique",
            "nombre_portes" => 4,
            "nombre_places" => 5,
            "prix_journalier" => 50.00
        ]);
        Vehicule::create    
        ([ 
            "immatriculation" => "IJ-789-KL",
            "marque" => "Ford",
            "modele" => "Focus",
            "couleur" => "Noir",
            "annee" => 2021,
            "kilometrage" => 10000,
            "energie" => "Hybride",
            "boite" => "Manuelle",
            "nombre_portes" => 5,
            "nombre_places" => 5,
            "prix_journalier" => 55.50
        ]);

    }
}
