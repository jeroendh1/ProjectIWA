<?php

namespace App\Http\Controllers\API;

use App\Helpers\TemperatureEstimator;
use App\Http\Controllers\Controller;
use App\Models\abonnement_type;
use App\Models\WeatherData;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherDataController extends Controller
{
    private string $dateFormat = 'Y-m-d H:i:s';

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
            $result = DB::select("
                SELECT *
                FROM weatherdata
                WHERE STN = '{$item['STN']}'
                ORDER BY DATE DESC
                LIMIT 30
            ");
            $weatherdata = new WeatherData();
            $weatherdata->stn =  strval($item["STN"]);
            $weatherdata->DATE = $item["DATE"];
            $weatherdata->TIME = $item["TIME"];
            $this->processTemp($weatherdata, $item['TEMP'], $item['DATE'], $item['TIME'], $result);
            $weatherdata->dewp = is_float($item["DEWP"]) ? $item["DEWP"] : null;
            $weatherdata->STP = is_float($item["STP"]) ? $item["STP"] : null;
            $weatherdata->SLP = is_float($item["SLP"]) ? $item["SLP"] : null;
            $weatherdata->VISIB = is_float($item["VISIB"]) ? $item["VISIB"] : null;
            $weatherdata->WDSP = is_float($item["WDSP"]) ? $item["WDSP"] : null;
            $weatherdata->PRCP = is_float($item["PRCP"]) ? $item["PRCP"] : null;
            $weatherdata->SNDP = is_float($item["SNDP"]) ? $item["SNDP"] : null;
            $weatherdata->FRSHTT = $item["FRSHTT"];
            $weatherdata->CLDC = is_float($item["CLDC"]) ? $item["CLDC"] : null;
            $weatherdata->WNDDIR = is_integer($item["WNDDIR"]) ? $item["WNDDIR"] : null;
            $weatherdata->save();
        }
    }

    private function processTemp(WeatherData $weatherData,
                                 float $temp,
                                 string $date,
                                 string $time,
                                 array $oldRecords): void
    {
        if (count($oldRecords) < 30) {
            $weatherData->temp = $temp;
            return;
        }

        $x = [];
        $y = [];
        $currentTime = strtotime("{$date} {$time}");
        $currentTemp = $temp;

        foreach ($oldRecords as $record) {
            $record = (array) $record;
            $x[] = strtotime("{$record['DATE']} {$record['TIME']}");
        }

        foreach ($oldRecords as $record) {
            $record = (array) $record;
            $y[] = $record['TEMP'];
        }

        $temperatureEstimator = new TemperatureEstimator($x, $y);

        $estimatedTemp = $temperatureEstimator->estimate($currentTime);

        $difference = $currentTemp - $estimatedTemp;

        $percentage = $estimatedTemp == 0 ? $difference * 100 : $difference / $estimatedTemp * 100;

        if ($percentage > 20 || $percentage < -20) {
            $weatherData->temp = round($estimatedTemp, 2);
            $weatherData->gecorrigeerde_data_id = 1;
        } else {
            $weatherData->temp = $temp;
        }
    }
}
