<?php

namespace App\Http\Controllers\API;

use App\Helpers\TemperatureEstimator;
use App\Http\Controllers\Controller;
use App\Models\abonnement;
use App\Models\abonnement_type;
use App\Models\customer;
use App\Models\OriginalWeatherData;
use App\Models\station;
use App\Models\User;
use App\Models\WeatherData;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WeatherDataController extends Controller
{
    private array $fields = [
        'temperature' => 'TEMP',
        'dew_point_temperature' => 'DEWP',
        'station_air_pressure' => 'STP',
        'sea_level_air_pressure' => 'SLP',
        'visibility' => 'VISIB',
        'wind_speed' => 'WDSP',
        'rainfall' => 'PRCP',
        'snow_depth' => 'SNDP',
        'frost' => 'FRSHTT',
        'rain' => 'FRSHTT',
        'snow' => 'FRSHTT',
        'hail' => 'FRSHTT',
        'storm' => 'FRSHTT',
        'tornado' => 'FRSHTT',
        'cloud_cover' => 'CLDC',
        'wind_direction' => 'WNDDIR',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $content =  $request->getContent();
        $content = json_decode($content, true);

        foreach ($content['WEATHERDATA'] as $item) {
            DB::transaction(function() use ($item) {
                $records = DB::select("
                    SELECT *
                    FROM weatherdata
                    WHERE STN = '{$item['STN']}'
                    ORDER BY DATE DESC
                    LIMIT 30
                ");

                if (count($records) >= 2) {
                    $x = [];
                    $y = [];

                    foreach ($records as $record) {
                        $record = (array) $record;
                        $x[] = strtotime("{$record['DATE']} {$record['TIME']}");
                    }

                    foreach ($records as $record) {
                        $record = (array) $record;
                        $y[] = $record['TEMP'];
                    }

                    $temperatureEstimator = new TemperatureEstimator($x, $y);

                    $item['ESTIMATED_TEMP'] = $temperatureEstimator
                        ->estimate(strtotime("{$item['DATE']} {$item['TIME']}"));
                } else {
                    $item['ESTIMATED_TEMP'] = $item['TEMP'];
                }



                if (!$this->isDataCorrect($item)) {
                    $owd = new OriginalWeatherData();
                    $owd->STN =     strval($item["STN"]);
                    $owd->DATE =    $item["DATE"];
                    $owd->TIME =    $item["TIME"];
                    $owd->TEMP =    $item["TEMP"];
                    $owd->DEWP =    is_float($item["DEWP"])     ? $item["DEWP"]     : null;
                    $owd->STP =     is_float($item["STP"])      ? $item["STP"]      : null;
                    $owd->SLP =     is_float($item["SLP"])      ? $item["SLP"]      : null;
                    $owd->VISIB =   is_float($item["VISIB"])    ? $item["VISIB"]    : null;
                    $owd->WDSP =    is_float($item["WDSP"])     ? $item["WDSP"]     : null;
                    $owd->PRCP =    is_float($item["PRCP"])     ? $item["PRCP"]     : null;
                    $owd->SNDP =    is_float($item["SNDP"])     ? $item["SNDP"]     : null;
                    $owd->FRSHTT =  $item["FRSHTT"];
                    $owd->CLDC =    is_float($item["CLDC"])     ? $item["CLDC"]     : null;
                    $owd->WNDDIR =  is_integer($item["WNDDIR"]) ? $item["WNDDIR"]   : null;
                    $owd->save();

                    $difference = $item['TEMP'] - $item['ESTIMATED_TEMP'];
                    $percentage = $item['ESTIMATED_TEMP'] == 0 ? $difference * 1000 : $difference / $item['ESTIMATED_TEMP'] * 100;

                    $wd = new WeatherData();
                    $wd->STN =     strval($item["STN"]);
                    $wd->DATE =    $item["DATE"];
                    $wd->TIME =    $item["TIME"];
                    $wd->TEMP =    $percentage > 20 || $percentage < -20 ? $item['ESTIMATED_TEMP'] : $item['TEMP'];
                    $wd->DEWP =    is_float($item["DEWP"])     ? $item["DEWP"]     : $this->average('DEWP', $records);
                    $wd->STP =     is_float($item["STP"])      ? $item["STP"]      : $this->average('STP', $records);
                    $wd->SLP =     is_float($item["SLP"])      ? $item["SLP"]      : $this->average('SLP', $records);
                    $wd->VISIB =   is_float($item["VISIB"])    ? $item["VISIB"]    : $this->average('VISIB', $records);
                    $wd->WDSP =    is_float($item["WDSP"])     ? $item["WDSP"]     : $this->average('WDSP', $records);
                    $wd->PRCP =    is_float($item["PRCP"])     ? $item["PRCP"]     : $this->average('PRCP', $records);
                    $wd->SNDP =    is_float($item["SNDP"])     ? $item["SNDP"]     : $this->average('SNDP', $records);
                    $wd->FRSHTT =  strlen($item["FRSHTT"])!=0  ? $item["FRSHTT"]   : $this->mostFrequent('FRSHTT', $records);
                    $wd->CLDC =    is_float($item["CLDC"])     ? $item["CLDC"]     : $this->average('CLDC', $records);
                    $wd->WNDDIR =  is_integer($item["WNDDIR"]) ? $item["WNDDIR"]   : $this->average('WNDDIR', $records);
                    $wd->original_data_id = $owd->id;
                    $wd->save();
                } else {
                    $wd = new WeatherData();
                    $wd->STN =     strval($item["STN"]);
                    $wd->DATE =    $item["DATE"];
                    $wd->TIME =    $item["TIME"];
                    $wd->TEMP =    $item['TEMP'];
                    $wd->DEWP =    $item["DEWP"];
                    $wd->STP =     $item["STP"];
                    $wd->SLP =     $item["SLP"];
                    $wd->VISIB =   $item["VISIB"];
                    $wd->WDSP =    $item["WDSP"];
                    $wd->PRCP =    $item["PRCP"];
                    $wd->SNDP =    $item["SNDP"];
                    $wd->FRSHTT =  $item["FRSHTT"];
                    $wd->CLDC =    $item["CLDC"];
                    $wd->WNDDIR =  $item["WNDDIR"];
                    $wd->save();
                }
            });
        }
    }

    private function isDataCorrect(array $data): bool
    {
        $difference = $data['TEMP'] - $data['ESTIMATED_TEMP'];
        $percentage = $data['ESTIMATED_TEMP'] == 0 ? $difference * 1000 : $difference / $data['ESTIMATED_TEMP'] * 100;

        if ($percentage > 20 || $percentage < -20)  return false;
        if (!is_float($data["DEWP"]))               return false;
        if (!is_float($data["STP"]))                return false;
        if (!is_float($data["SLP"]))                return false;
        if (!is_float($data["VISIB"]))              return false;
        if (!is_float($data["WDSP"]))               return false;
        if (!is_float($data["PRCP"]))               return false;
        if (!is_float($data["SNDP"]))               return false;
        if (!is_float($data["CLDC"]))               return false;
        if (strlen($data["FRSHTT"]) == 0)           return false;
        if (!is_integer($data["WNDDIR"]))           return false;

        return true;
    }

    private function average(string $key, array $records) {
        $sum = 0;
        foreach ($records as $record) {
            $record = (array) $record;
            $sum += $record[$key];
        }
        return count($records) ? $sum / count($records) : 0;
    }

    private function mostFrequent(string $key, array $records) {
        $map = [];

        foreach ($records as $record) {
            $record = (array) $record;
            if (!array_key_exists($record[$key], $map)) {
                $map[$record[$key]] = 1;
            } else {
                $map[$record[$key]] += 1;
            }
        }

        return array_search(max($map), $map);
    }

    public function getField(Request $request, String $token) {
        $subscription = abonnement::query()
            ->select()
            ->where('token', '=', $token)
            ->first();

        // check if subscription token is valid
        if (is_null($subscription)) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        // check if both dates are set
        if ((empty($date_start) && !empty($date_end)) || (empty($date_end) && !empty($date_start))) {
            return response()->json(['message' => 'Both dates need to be specified.'], 500);
        }

        // check if both dates are valid
        foreach ([$date_start, $date_end] as $date) {
            if (!strtotime($date) && $date != "") {
                return response()->json(['message' => 'Date is not valid: ' . $date], 500);
            }
        }

        $columns = explode(",", $request->input('columns'));

        $select_string = [
            "weatherdata.STN as station_id",
            "nearestlocations.name as location",
            "countries.country",
            "nearestlocations.longitude",
            "nearestlocations.latitude",
            "weatherdata.DATE as date",
            "weatherdata.TIME as time",
        ];

        // check if columns are valid or specified
        foreach ($columns as $column) {
            if (!array_key_exists($column, $this->fields) && $column != "") {
                return response()->json(['message' => 'column does not exists: ' . $column], 500);
            } else if ($column != "") {
                array_push($select_string, "weatherdata.{$this->fields[$column]} as {$column}");
            } else {
                // add all columns
                foreach ($this->fields as $key => $field) {
                    array_push($select_string, "weatherdata.{$field} as {$key}");
                }
            }
        }

        // retrieve associated data
        $query = abonnement::query()
            ->select($select_string)
            ->join('abonnement_stations', 'abonnement_stations.abonnement_id', 'abonnements.abonnement_id')
            ->join('weatherdata', 'weatherdata.STN', 'abonnement_stations.station_id')
            ->join('nearestlocations', 'nearestlocations.station_id', 'abonnement_stations.station_id')
            ->join('countries', 'countries.country_code', 'nearestlocations.country_code');

        if ($date_start != "" && $date_end != "") {
            $query = $query->whereBetween('weatherdata.DATE', [$date_start, $date_end]);
        } else {
            $query = $query->where([
                ['weatherdata.id', '=', function ($query) {
                    $query->select('weatherdata.id')
                        ->from('weatherdata')
                        ->whereColumn('weatherdata.STN', 'abonnement_stations.station_id')
                        ->orderByDesc('weatherdata.DATE')
                        ->orderByDesc('weatherdata.TIME')
                        ->limit(1);
                }],
            ]);
        }

        $query = $query->where([
            ['abonnements.token', '=', $token],
        ])->orderBy('weatherdata.DATE')
            ->orderBy('weatherdata.TIME');

        $records = $query->get()->toArray();

        $data = [];

        foreach ($records as $record) {
            $key = $record["station_id"];
            if (!array_key_exists($key, $data)) {
                $data[$key] = [
                    "location" => $record["location"],
                    "country" => $record["country"],
                    "longitude" => $record["longitude"],
                    "latitude" => $record["latitude"],
                    "data" => []
                ];
            }
            $temp = [
                "date" => $record["date"],
                "time" => $record["time"],
            ];
            foreach($columns as $column) {
                $temp[$column] = $record[$column];
            }
            $data[$key]["data"][] = $temp;
        }

        return response()->json($data);
    }
}
