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
        'dew-point-temperature' => 'DEWP',
        'station-air-pressure' => 'STP',
        'sea-level-air-pressure' => 'SLP',
        'visibility' => 'VISIB',
        'wind-speed' => 'WDSP',
        'rainfall' => 'PRCP',
        'snow-depth' => 'SNDP',
        'frost' => 'FRSHTT',
        'rain' => 'FRSHTT',
        'snow' => 'FRSHTT',
        'hail' => 'FRSHTT',
        'storm' => 'FRSHTT',
        'tornado' => 'FRSHTT',
        'cloud-cover' => 'CLDC',
        'wind-direction' => 'WNDDIR',
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
                    $wd->FRSHTT =  strlen($item["FRSHTT"])!=0  ? $item["FRSHTT"]   : $this->mostFrequent($records);
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
                    $wd->STP =     $item["DEWP"];
                    $wd->SLP =     $item["DEWP"];
                    $wd->VISIB =   $item["DEWP"];
                    $wd->WDSP =    $item["DEWP"];
                    $wd->PRCP =    $item["DEWP"];
                    $wd->SNDP =    $item["DEWP"];
                    $wd->FRSHTT =  $item["FRSHTT"];
                    $wd->CLDC =    $item["DEWP"];
                    $wd->WNDDIR =  $item["DEWP"];
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

    private function mostFrequent(array $records) {
        $map = [];

        foreach ($records as $record) {
            $record = (array) $record;
            if (!array_key_exists($record['FRSHTT'], $map)) {
                $map[$record['FRSHTT']] = 1;
            } else {
                $map[$record['FRSHTT']] += 1;
            }
        }

        return array_search(max($map), $map);
    }

    public function getField(Request $request, String $column, String $token) {
        $subscription = abonnement::query()
            ->select()
            ->where('token', '=', $token)
            ->first();

        // check if subscription token is valid
        if (is_null($subscription)) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // check if column exists
        if (!array_key_exists($column, $this->fields)) {
            return response()->json(['message' => 'column does not exists'], 500);
        }

        $propertyName = str_replace('-', '_', $column);

        // retrieve associated data
        $data = abonnement::query()
            ->select([
                "weatherdata.STN as station_id",
                "nearestlocations.name as location",
                "countries.country",
                "nearestlocations.longitude",
                "nearestlocations.latitude",
                "weatherdata.{$this->fields[$column]} as {$propertyName}",
                "weatherdata.DATE as date",
                "weatherdata.TIME as time",
            ])
            ->join('abonnement_stations', 'abonnement_stations.abonnement_id', 'abonnements.abonnement_id')
            ->join('weatherdata', 'weatherdata.STN', 'abonnement_stations.station_id')
            ->join('nearestlocations', 'nearestlocations.station_id', 'abonnement_stations.station_id')
            ->join('countries', 'countries.country_code', 'nearestlocations.country_code')
            ->where([
                ['weatherdata.id', '=', function ($query) {
                    $query->select('weatherdata.id')
                        ->from('weatherdata')
                        ->whereColumn('weatherdata.STN', 'abonnement_stations.station_id')
                        ->orderByDesc('weatherdata.DATE')
                        ->orderByDesc('weatherdata.TIME')
                        ->limit(1);
                }],
                ['abonnements.token', '=', $token]
            ])
            ->get();


        return response()->json($data);
    }
}
