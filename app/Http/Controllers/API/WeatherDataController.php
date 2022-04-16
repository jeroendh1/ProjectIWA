<?php

namespace App\Http\Controllers\API;

use App\Helpers\TemperatureEstimator;
use App\Http\Controllers\Controller;
use App\Models\abonnement_type;
use App\Models\OriginalWeatherData;
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
            DB::transaction(function() use ($item) {
                $records = DB::select("
                    SELECT *
                    FROM weatherdata
                    WHERE STN = '{$item['STN']}'
                    ORDER BY DATE DESC
                    LIMIT 30
                ");

                if (count($records) >= 10) {
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
                    $wd->DEWP =    is_float($item["DEWP"])     ? $item["DEWP"]     : null; // average value
                    $wd->STP =     is_float($item["STP"])      ? $item["STP"]      : null; // average value
                    $wd->SLP =     is_float($item["SLP"])      ? $item["SLP"]      : null; // average value
                    $wd->VISIB =   is_float($item["VISIB"])    ? $item["VISIB"]    : null; // average value
                    $wd->WDSP =    is_float($item["WDSP"])     ? $item["WDSP"]     : null; // average value
                    $wd->PRCP =    is_float($item["PRCP"])     ? $item["PRCP"]     : null; // average value
                    $wd->SNDP =    is_float($item["SNDP"])     ? $item["SNDP"]     : null; // average value
                    $wd->FRSHTT =  $item["FRSHTT"];
                    $wd->CLDC =    is_float($item["CLDC"])     ? $item["CLDC"]     : null; // average value
                    $wd->WNDDIR =  is_integer($item["WNDDIR"]) ? $item["WNDDIR"]   : null; // average value
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
        if (!is_integer($data["WNDDIR"]))           return false;

        return true;
    }
}
