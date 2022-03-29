<?php

namespace Database\Seeders;

use App\Models\abonnement_type;
use App\Models\user_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class user_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user_type::create([

           'type' => 'Admin'
        ]);
        user_type::create([

            'type' => 'Klant'
        ]);
        user_type::create([

            'type' => 'Medewerker'
        ]);
        abonnement_type::create([
            'type' => 'type1'
        ]);
    }

}
