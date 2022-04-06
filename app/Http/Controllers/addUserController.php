<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class addUserController extends Controller
{
    public function getusers(){
        $users = DB::table('users')
            ->get();
        return view('addUser', ['users' => $users]);
    }
    public function addUser(Request $request){
        error_log($request);
        $user = new User;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->city = $request->city;
        $user->last_login = Carbon::now()->format('Y-m-d H:i:s') ;
        $user->admin = $request->admin == 'on' ? 1 : 0;
        $user->save();
        return redirect('addUser')->with('status', 'record succesfull inserted');

    }
    public function editUser(Request $request, $user_id){
        $user = User::find($user_id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->city = $request->city;
        $user->save();
        return redirect('addUser')->with('status', 'record succesfull updated');

    }
    public function deleteUser(Request $request, $user_id){
        $user = User::find($user_id);
        $user->delete();
        return redirect('addUser')->with('status', 'record succesfull deleted');
    }
}
