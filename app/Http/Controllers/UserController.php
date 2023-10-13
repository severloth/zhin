<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function storage()
    {
        $data = request()->validate([
            'name' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'password' => 'required'
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'lastname.required' => 'El campo apellido es obligatorio',
            'username.required' => 'El campo nombre de usuario es obligatorio',
            'password.required' => 'El campo password es obligatorio'
        ]);

        //IF USERNAME EXISTS IN DATABASE, RETURN THE VIEW WITH A MESSAGE
        //ELSE, CREATE THE USER AND REDIRECT TO THE INDEX
        $user = User::where('username', $data['username'])->first();
        if($user){
            return back()->with('message', 'El nombre de usuario ya existe, por favor elija otro');
        }



        User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'password' => bcrypt( $data['password'] )
        ]);

        

        //return to login index with message

        return redirect()->route('login')->with('message', 'Usuario creado con éxito');
    }
}
