<?php

namespace Database\Seeders;

use App\Models\abonnement;
use App\Models\Users;
use Illuminate\Support\Carbon;
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
//        Users::create([
//
//            'username'    => 'user1',
//            'password'   =>  Hash::make('hoi123'),
//            'first_name'    => 'test',
//            'last_name' => 'test',
//            'email'=> 'test@t.nl',
//            'city' => 'NL',
//            'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
//            'user_type_id' => '2',
//        ]);
        abonnement::create([

            'user_id'   => 3,
            'start_date'   =>  '2022-03-29 20:02:53',
            'end_date'    => '2023-03-29 20:02:53',
            'active' => 1,
            'last_update'=> Carbon::now()->format('Y-m-d H:i:s'),
            'abonnement_type_id' => 1,
        ]);
    }
}
