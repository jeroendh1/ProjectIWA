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
        Users::create([
            'username'    => 'user',
            'password'   =>  Hash::make('hoi123'),
        ]);
    }
}
