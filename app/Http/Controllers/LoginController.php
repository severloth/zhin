<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login()
    {
        $credentials = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'El campo nombre de usuario es obligatorio',
            'password.required' => 'El campo password es obligatorio'
        ]);
      
        //Check if the account exists

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->route('main.index');
        }

        return  back()->withErrors([         
            'username' => 'Las credenciales no coinciden con nuestros registros'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login.index');
    }
}
