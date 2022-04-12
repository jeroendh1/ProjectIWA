<?php

namespace Database\Seeders;

use App\Models\geolocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeolocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
 $csvFile = fopen(base_path("database/data/geolocations.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 3000, ",")) !== FALSE) {
            if (!$firstline) {
                geolocation::create([
                    "id" => $data['0'],
                    "station_id" => $data['1'],
                    "country_code" => $data['2'],
                    "island" => $data['3'],
                    "county" => $data['4'],
                    "place" => $data['5'],
                    "hamlet" => $data['6'],
                    "town" => $data['7'],
                    "municipality" => $data['8'],
                    "state_district" => $data['9'],
                    "administrative" => $data['10'],
                    "state" => $data['11'],
                    "village" => $data['12'],
                    "region" => $data['13'],
                    "province" => $data['14'],
                    "city" => $data['15'],
                    "locality" => $data['16'],
                    "postcode" => $data['17'],
                    "country" => $data['18'],
                    
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
