<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class MainController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(20);
        
        $allUsers = User::all();

        $usuario = User::find(auth()->user()->id);
      
        return view('main.index', compact('posts', 'usuario', 'allUsers'));
    }
}
