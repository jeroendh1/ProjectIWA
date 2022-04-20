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

        $vars += $this->getStations();
        $vars += $this->getCountries();
        $vars += $this->getLocations();
        $vars += $this->getStatuses();
        $vars += $this->getMalfunctions($request, $vars['statuses']);

        return view('home', $vars);
    }

    public function getMalfunctions(Request $request, $statuses) {
//        echo '<br><br><br><br><br><pre>';
        $filter = $this->filter($request, $statuses);
        $query = 'select stations.station_id, stations.longitude, stations.latitude, nl.name, c.country from stations
            join geolocations gs on stations.station_id = gs.station_id
            join countries c on gs.country_code = c.country_code
            join nearestlocations nl on stations.station_id = nl.station_id'
            .$filter;
        $tableMalfunctions = DB::select($query);
        return ['malfunctions' => $tableMalfunctions];
    }

    public function getStations() {
        $tableStations = DB::select('select station_id from stations');
        sort($tableStations);
        return ['stations' => $tableStations];
    }

    public function getCountries() {
        $tableCountries = DB::select('select distinct country from countries');
        sort($tableCountries);
        return ['countries' => $tableCountries];
    }

    public function getStatuses() {
        $stations = $this->getStations();
        $tableStatuses = array();
        foreach ($stations['stations'] as $station) {
            $output = $this->getStatus($station);
            if ($output != []) {
                if ($output[0]->original_data_id == null) $tableStatuses += [$output[0]->STN => true];
                else $tableStatuses += [$output[0]->STN => false];
            } else {
                $tableStatuses += [$station->station_id => true];
            }
        }
        return ['statuses' => $tableStatuses];
    }

    public function getLocations() {
        $tableLocations = DB::select('select distinct name from nearestlocations');
        sort($tableLocations);
        return ['locations' => $tableLocations];
    }

    public function getStatus($station)
    {
        $output = DB::select("
            select STN, original_data_id from weatherdata
            where STN = $station->station_id
            order by DATE desc, TIME desc
            limit 1
        ");
        return $output;
    }

    public function filter(Request $request, $statuses): string
    {
        $filter = '';
        if ($request->station_naam!='null' && $request->station_naam!='') {
            $station_naam = $request->station_naam;
            if ($filter == '') $filter .= " where stations.station_id = $station_naam ";
            else $filter .= ' and stations.station_id = $station_naam ';
        }
        if ($request->land!='null' && $request->land!='') {
            $land = $request->land;
            $land = str_replace("'","\'", $land);
            if ($filter == '') $filter .= " where c.country = '$land' ";
            else $filter .= " and c.country = '$land' ";
        }
        if ($request->locatie!='null' && $request->locatie!='') {
            $locatie = $request->locatie;
            $locatie = str_replace("'","\'", $locatie);
            if ($filter == '') $filter .= " where nl.name = '$locatie' ";
            else $filter .= " and nl.name = '$locatie' ";
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
        if ($request->status!='null' && $request->status!='') {
            $status = $request->status;
            if ($filter == '') $filter .= " where (";
            else $filter .= " and (";
            if ($status == 'storing') {
                foreach ($statuses as $key => $status) {
                    if ($status == false) $filter .= "stations.station_id = $key or ";
                }
            } else {
                foreach ($statuses as $key => $status) {
                    if ($status == false) $filter .= "stations.station_id != $key and ";
                }
            }
            $filter = substr($filter,0,-4);
            $filter .= ') ';
        }
        if ($request->aantal!='all') {
            if ($request->aantal == "") {

                $filter .= " limit 100 ";
            } else {
                $aantal = $request->aantal;
                $filter .= " limit $aantal ";
            }
        }
        return $filter;
    }
}
