<?php

namespace Database\Seeders;

use App\Models\customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         customer::create([
            'first_name'    => 'john',
            'last_name' => 'doe',
            'email'=> 'johndoe@iwa.nl',
            'token'=> hash('sha256', Str::random(60)),
        ]);
        customer::create([
            'first_name'    => 'test',
            'last_name' => 'klant1',
            'email'=> 'testkLant1@iwa.nl',
            'token'=> hash('sha256', Str::random(60)),
        ]);
        customer::create([
            'first_name'    => 'test',
            'last_name' => 'klant2',
            'email'=> 'testllant2@iwa.nl',
            'token'=> hash('sha256', Str::random(60)),
        ]);
    }
}
