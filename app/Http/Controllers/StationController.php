<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StationController
{
    public function station($station_id) {
        $station = $this->getSingleStation($station_id);
        $charts = $this->getCharts($station_id);
//        var_dump($charts);
//        $station = station::find($station_id);

        return view('station', ['station' => $station, 'charts' => $charts]);
    }

    public function getSingleStation($station_id) {
        $query = "select stations.station_id, stations.longitude, stations.latitude, nl.name, c.country from stations
            join geolocations gs on stations.station_id = gs.station_id
            join countries c on gs.country_code = c.country_code
            join nearestlocations nl on stations.station_id = nl.station_id
            where stations.station_id = $station_id";

        $tableStation = DB::select($query);
        return $tableStation[0];
    }

    public function getSingleStationData($station_id) {
        $query = "select * from weatherdata where STN = $station_id";

        $tableSingleStationData = DB::select($query);

//        echo '<br>';echo '<br>';echo '<br>';echo '<br>';
//        var_dump($tableSingleStationData);

        if ($tableSingleStationData) {
            return $tableSingleStationData;
        }
        return false;
    }


    public function getCharts($station_id)
    {
//        echo '<pre>';
//        echo '<br>';echo '<br>';echo '<br>';echo '<br>';
//        var_dump($this->getSingleStationData($station_id));
        if (!$this->getSingleStationData($station_id)) return false;
        $charts = array();
        $charts += ['temperatuur' => $this->getChartData($station_id, 'TEMP')];
        $charts += ['dewp' => $this->getChartData($station_id, 'DEWP')];
        $charts += ['stp' => $this->getChartData($station_id, 'STP')];
        $charts += ['slp' => $this->getChartData($station_id, 'SLP')];
        $charts += ['visib' => $this->getChartData($station_id, 'VISIB')];
        $charts += ['wdsp' => $this->getChartData($station_id, 'WDSP')];
        $charts += ['prcp' => $this->getChartData($station_id, 'PRCP')];
        $charts += ['sndp' => $this->getChartData($station_id, 'SNDP')];
        $charts += ['frshtt' => $this->getChartData($station_id, 'FRSHTT')];
        $charts += ['cldc' => $this->getChartData($station_id, 'CLDC')];
        $charts += ['wnddir' => $this->getChartData($station_id, 'WNDDIR')];
//        var_dump($charts);
        return $charts;
    }

    public function getChartData($station_id, $dataType)
    {
        $dots = array();
        $result = array();
        $data = $this->getSingleStationData($station_id);

        foreach ($data as $item) {
            $hour = explode(':',$item->TIME)[1];
            if (!isset($dots[$item->DATE.', '.$hour.' uur'])) $dots += [$item->DATE.', '.$hour.' uur' => [$item->$dataType]];
            else $dots[$item->DATE.', '.$hour.' uur'][] = $item->$dataType;
        }
        foreach ($dots as $key => $dot) {
            if (!isset($result[0])) {
                $result[] = [$key];
                $result[] = [round(array_sum($dot) / count($dot),2)];
            }
            else {
                $result[0][] = $key;
                $result[1][] = round(array_sum($dot) / count($dot), 2);
            }
        }
//        var_dump($result);

        return $result;

    }
}
