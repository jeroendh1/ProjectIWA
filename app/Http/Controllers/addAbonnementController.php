<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use mysql_xdevapi\Table;

class addAbonnementController extends Controller
{
    public function getAbonnementen(){
        $abonnementen = DB::table('abonnements')
            ->join('customers', 'abonnements.customer_id', '=', 'customers.customer_id')
            ->join('abonnement_types', 'abonnements.abonnement_type_id', '=', 'abonnement_types.id')
            ->get();

        $abonnement_types = DB::table('abonnement_types')
            ->get();
        return view('addAbonnement', ['abonnementen' => $abonnementen, 'abonnement_types' => $abonnement_types]);
    }
    public function addAbonnement(Request $request){
        $abonnement = new abonnement;

        if($request->filled('customer_id')){
            $abonnement->customer_id = $request->customer_id;
        }else if($request->filled('customer_email')){
            $get_customer_id = DB::table('customers')->where('email', $request->customer_email)->first();
            if(!$get_customer_id){return $this->errormsg(); }
            $abonnement->customer_id = $get_customer_id->customer_id;
        }else{
            return $this->errormsg();
        }

        $abonnement->start_date = $request->start_date;
        $abonnement->end_date = $request->end_date;
        $abonnement->abonnement_type_id = $request->abonnement_type;
        $abonnement->token = hash('sha256', Str::random(60));
        $abonnement->save();
        return redirect('addAbonnement')->with('success', 'record succesfull inserted');

    }
    public function editAbonnement(Request $request, $abonnement_id){
        $abonnement = abonnement::find($abonnement_id);
        error_log($request);
        $abonnement->start_date = $request->start_date;
        $abonnement->end_date = $request->end_date;
        $abonnement->token = $request->gt;
        $abonnement->abonnement_type_id = $request->abonnement_type;
        $abonnement->save();
        return redirect('addAbonnement')->with('success', 'record succesfull updated');

    }
    public function deleteAbonnement(Request $request, $abonnement_id){
        $abonnement = abonnement::find($abonnement_id);
        $abonnement->delete();
        return redirect('addAbonnement')->with('success', 'record succesfull deleted');
    }
    public function errormsg(){
        return back()->with('error', 'Klant niet gevonden');
    }
    public static function generateToken(){
        return hash('sha256', Str::random(60));;
    }
}
