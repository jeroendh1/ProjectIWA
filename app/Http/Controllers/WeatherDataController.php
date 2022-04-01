<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class WeatherDataController extends Controller
{
    public function insertData(Request $request): string
    {
        $data = $request->getContent();

        $json = json_decode($data, true);

        return var_dump($json);
    }
}
