<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Table;

class addAbonnementController extends Controller
{
    public function getAbonnementen(){
        $abonnementen = DB::table('abonnements')
            ->join('users', 'abonnements.user_id', '=', 'users.user_id')
            ->join('abonnement_types', 'abonnements.abonnement_type_id', '=', 'abonnement_types.id')
            ->get();
        $abonnement_types = DB::table('abonnement_types')
            ->get();
        return view('addAbonnement', ['abonnementen' => $abonnementen, 'abonnement_types' => $abonnement_types]);
    }
    public function addAbonnement(Request $request){
        $abonnement = new abonnement;

        if($request->has('user_id')){
            $abonnement->user_id = $request->user_id;
        }else{
            $get_user_id = DB::table('users')->where('email', $request->useremail)->first();
            $abonnement->user_id = $get_user_id->user_id;
        }

        $abonnement->start_date = $request->start_date;
        $abonnement->end_date = $request->end_date;
        $abonnement->active = 1;
        $abonnement->abonnement_type_id = $request->abonnement_type_id;
        $abonnement->save();
        return redirect('addAbonnemet')->with('status', 'record succesfull inserted');

    }
    public function editAbonnement(Request $request, $abonnement_id){
        $abonnement = abonnement::find($abonnement_id);
        $abonnement->start_date = $request->start_date;
        $abonnement->end_date = $request->end_date;
        $abonnement->active = 1;
        $abonnement->abonnement_type_id = $request->abonnement_type_id;
        $abonnement->save();
        return redirect('addAbonnemet')->with('status', 'record succesfull updated');

    }
    public function deleteAbonnement(Request $request, $abonnement_id){
        $abonnement = abonnement::find($abonnement_id);
        $abonnement->delete();
        return redirect('addAbonnemet')->with('status', 'record succesfull deleted');
    }
}
