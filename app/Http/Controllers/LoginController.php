<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credential = $request->only(['email', 'password']);
        if (Auth::attempt($credential)) {
            return redirect()->intended('timeline');
        }
        Alert::warning('Warning Title', 'Warning Message');
        return redirect()->back()->withErrors(['Login gagal. Mohon periksa kembali email dan password anda!']);
    }
}
