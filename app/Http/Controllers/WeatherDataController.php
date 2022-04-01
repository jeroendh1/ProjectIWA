<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class WeatherDataController extends Controller
{
    public function insertData(Request $request): string
    {
        error_log(file_get_contents("php://input"));

        return "Success";
    }
}
