<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class WeatherDataController extends Controller
{
    public function insertData(Request $request): string
    {
        $content = $request->getContent();
        $json = json_decode($content, true);
        $collection = $json['WEATHERDATA'];

        foreach ($collection as $station_key => $document)
        {
            foreach ($document as $field_key => $field)
            {

            }
        }

        return "REQUEST SUCCESSFUL";
    }
}
