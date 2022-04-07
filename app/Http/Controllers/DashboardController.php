<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function getMalfunctions() {
        $tableMalfunctions = DB::select('select s.station_id, s.longitude, c.country from stations s
            join geolocations gs on s.station_id = gs.station_id
            join countries c on gs.country_code = c.country_code order by longitude desc');

        return view('home', ['malfunctions' => $tableMalfunctions]);
    }

    public function getCountries() {
        $tableCountries = DB::select('select * from countries');
        return view('home', ['countries' => $tableCountries]);
    }

//    public function getCountry(string $country) {
//        $tableCountry = DB::select("select * from countries where country = ".$country);
//        return view('home', [$country => $tableCountry]);
//    }

}
