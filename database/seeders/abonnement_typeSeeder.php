<?php

namespace Database\Seeders;

use App\Models\abonnement_type;
use App\Models\user_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class abonnement_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        abonnement_type::create([
            'id' => 1,
            'omschrijving' => '1 station met periodieke gegevens.'
        ]);
        abonnement_type::create([
            'id' => 2,
            'omschrijving' => 'Meerdere stations met periodieke gegevens.'
        ]);
        abonnement_type::create([
            'id' => 3,
            'omschrijving' => '1 station met actuele gegevens.'
        ]);
    }

}
