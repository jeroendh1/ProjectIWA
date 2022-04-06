<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< Updated upstream
        Users::create([
            'username'    => 'user',
            'password'   =>  Hash::make('hoi123'),
        ]);
=======

        // Deze waarde bepaald wat er gemaakt wordt
        // Geldige opties zijn: user, abonnement
        $create = 'abonnement';

        if ($create == 'user') {
            Users::create([

                'username' => 'user',
                'password' => Hash::make('hoi123'),
                'first_name' => 'john',
                'last_name' => 'doe',
                'email' => 'johndoe@t.nl',
                'city' => 'NL',
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'user_type_id' => '1',
            ]);
        } elseif ($create == 'abonnement') {
            abonnement::create([

                'user_id' => 2,
                'start_date' => '2022-03-29 20:02:53',
                'end_date' => '2023-03-29 20:02:53',
                'active' => 1,
                'last_update' => Carbon::now()->format('Y-m-d H:i:s'),
                'abonnement_type_id' => 1,
            ]);
        }
>>>>>>> Stashed changes
    }
}
