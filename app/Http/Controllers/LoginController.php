<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AuthenticatesAndRegistersUsers;
class LoginController extends Controller
{
//    public function submit(){
//        return 123;
//    }
    function index()
    {
        return view('login');
    }

    function checklogin(Request $request)
    {   error_log($request->get('username'));
        $user_data = array(
            'username'  => $request->get('username'),
            'password' => $request->get('password')
        );
        if(Auth::attempt($user_data))
        {
            return redirect('home');
        }
        else
        {
            return back()->with('error', 'Verkeerde inlog gegevens');
        }

    }

    function successlogin()
    {
        return view('home');
    }
    function logout()
    {
        Auth::logout();
        return redirect('login');
    }

}
