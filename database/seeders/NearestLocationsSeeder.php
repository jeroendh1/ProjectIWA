<?php

namespace Database\Seeders;

use App\Models\nearestlocation;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NearestLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
 $csvFile = fopen(base_path("database/data/nearestlocations.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 3000, ",")) !== FALSE) {
            if (!$firstline) {
                nearestlocation::create([
                    "id" => $data['0'],
                    "station_id" => $data['1'],
                    "name" => $data['2'],
                    "administrative_region1" => $data['3'],
                    "administrative_region2" => $data['4'],
                    "country_code" => $data['5'],
                    "longitude" => $data['6'],
                    "latitude" => $data['7']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
