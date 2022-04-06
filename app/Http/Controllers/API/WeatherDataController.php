<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\abonnement_type;
use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherDataController extends Controller
{
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
            $weatherdata = new WeatherData();
            $weatherdata->stn =  strval($item["STN"]);
            $weatherdata->DATE = $item["DATE"];
            $weatherdata->TIME = $item["TIME"];
            $weatherdata->temp = $item["TEMP"];
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
