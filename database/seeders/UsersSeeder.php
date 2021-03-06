<?php

namespace Database\Seeders;

use App\Models\abonnement;
use App\Models\customer;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([

            'username'    => 'user',
            'password'   =>  Hash::make('hoi123'),
            'first_name'    => 'john',
            'last_name' => 'doe',
            'email'=> 'johndoe@t.nl',
            'functie' => 'admin',
            'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
            'admin' => '1',
        ]);
//
//        abonnement::create([
//
//            'customer_id'   => 1,
//            'start_date'   =>  '2022-03-29 20:02:53',
//            'last_update'=> Carbon::now()->format('Y-m-d H:i:s'),
//            'abonnement_type_id' => 1,
//        ]);
    }
}
