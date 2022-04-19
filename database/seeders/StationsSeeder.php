<?php

namespace Database\Seeders;

use App\Models\station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
     
 $csvFile = fopen(base_path("database/data/stations.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 3000, ",")) !== FALSE) {
            if (!$firstline) {
                station::create([
                    "station_id" => $data['0'],
                    "longitude" => $data['1'],
                    "latitude" => $data['2'],
                    "elevation" => $data['3']

                     
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}