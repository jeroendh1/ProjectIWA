<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\station;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function getVariables(Request $request) {
        $vars = array();
        $vars += $this->getMalfunctions($request);
        $vars += $this->getStations();
        $vars += $this->getCountries();
        $vars += $this->getLocations();

        return view('home', $vars);
    }

    public function getMalfunctions(Request $request) {
        $filter = $this->filter($request);
        $query = 'select station_name, longitude, latitude, locality, c.country from stations
            join geolocations gs on stations.stn_name=gs.station_name
            join countries c on gs.country_code = c.country_code '
            .$filter.' order by longitude desc';
        $tableMalfunctions = DB::select($query);
        return ['malfunctions' => $tableMalfunctions];
    }

    public function getStations() {
        $tableStations = DB::select('select stn_name from stations');
        return ['stations' => $tableStations];
    }

    public function getCountries() {
        $tableCountries = DB::select('select distinct country from countries');
        return ['countries' => $tableCountries];
    }

    public function getStatuses() {
        $tableStatuses = DB::select('select distinct longitude from stations');
        return ['statuses' => $tableStatuses];
    }

    public function getLocations() {
        $tableLocations = DB::select('select distinct locality from geolocations');
        return ['locations' => $tableLocations];
    }

    public function station($stn_name) {
        $station = station::find($stn_name);
        return ['station' => $station];
    }

    public function filter(Request $request): string
    {
        $filter = '';
        if ($request->station_naam!='null') {
            if ($filter == '') $filter .= "where stn_name = '$request->station_naam' ";
            else $filter .= "and stn_name = '$request->station_naam' ";
        }
        if ($request->land!='null') {
            if ($filter == '') $filter .= "where c.country = '$request->land' ";
            else $filter .= "and c.country = '$request->land' ";
        }
        if ($request->locatie!='null') {
            if ($filter == '') $filter .= "where gs.locality = '$request->locatie' ";
            else $filter .= "and gs.locality = '$request->locatie' ";
        }
//       Filter voor coördinaten, werkt maar filter is niet nuttig.
//       Om te gebruiken uncomment code in home.blade.php

//        if ($request->coordinaten!=NULL) {
//            echo 'filter coordinaten <br><br><br>';
//            var_dump($request->coordinate);
//            $coordinaten = explode(',',$request->coordinaten);
//            var_dump($coordinaten);
//            if ($filter == '') $filter .= "where longitude = '$coordinaten[0]' and latitude = '$coordinaten[1]' ";
//            else $filter .= "and longitude = '$coordinaten[0]' and latitude = '$coordinaten[1]' ";
//        }
        if ($request->status!='null') {
            if ($request->status == 'storing') {
                if ($filter == '') $filter .= "where longitude = 0.9999";
                else $filter .= "and longitude = 0.9999";
            } else {
                if ($filter == '') $filter .= "where longitude != 0.9999";
                else $filter .= "and longitude != 0.9999";
            }
        }
        return $filter;
    }
}
