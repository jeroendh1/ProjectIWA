<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function getCountries() {
        $tableCountries = DB::select('select * from countries');
        return view('home', ['countries' => $tableCountries]);
    }
}
