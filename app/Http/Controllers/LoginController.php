<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function postlogin(Request $request)
    {
        $user = $request->username;
        $pass = $request->password;

        $login = Login::where('username', $user)->where('password', $pass)->first();
        if ($login) {
            session(['yangmasuk' => $user]);
            session(['namayangmasuk' => $user]);
            session(['idyangmasuk' => $login->id]);
            return redirect('');
        } else {
            Session::flash('pesan', 'Data yang anda masukkan salah!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect('login');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('login');
    }
}