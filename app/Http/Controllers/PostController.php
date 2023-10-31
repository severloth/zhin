<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Illuminate\Support\Facades\Log; // Agrega esta línea


use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Notice;
use Illuminate\Notifiations\Notifiable;
use Illuminate\Support\Facades\Config;
use App\Notifications\TelegramPost;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{

 

    private function createSlug(){
        //auto increment number
        $slug = Post::count() + 1;
        return $slug;  

    }

    public function store(){
        $data = request()->validate([
            'content' => 'required',
        ], [
            'content.required' => 'El campo de contenido está vacío',
            
        ]);

        Post::create([
            'content' => $data['content'],
            'slug'  => $this->createSlug(),
            'user_id' => auth()->user()->id,
            'likes' => 0,
            'comments' => 0

        ]);
        
        $user = User::find(auth()->user()->id);

        $notice = new Notice([
            'id' => Uuid::uuid4()->toString(),
            'notice' => "No te lo pierdas!",
            'noticedes' => "Nuevo post creado por {$user->name} {$user->lastname}:\n{$data['content']}",
            'noticelink' => 'https://google.com',
            'telegramid' => Config::get('services.telegram_id'),

        ]);

        $notice->save();
        
        $notice ->notify(new TelegramPost());
    


        return redirect()->route('main.index');
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->first();
        $comments = json_decode($post->comments_detail, true);
        $user = User::find(auth()->user()->id);
        return view('main.show', ['post' => $post, 'comments' => $comments, 'user' => $user]);
    }


    public function addLike($slug)
    {
        $user = User::find(auth()->user()->id);
        $post = Post::where('slug', $slug)->firstOrFail();
    
        // Decodificar la columna liked_by en un array
        $array = json_decode($post->liked_by, true);

        if (is_null($post->liked_by)) {
            $array = [];
        }
    
        if (in_array($user->id, $array)) {
            // Eliminar el usuario del array
            $array = array_diff($array, [$user->id]);
            $post->liked_by = json_encode($array);
            $post->likes = $post->likes - 1;
        } else {
            // Agregar el usuario al array
            array_push($array, $user->id);
            $post->liked_by = json_encode($array);
            $post->likes = $post->likes + 1;
        }
    
        $post->save();
       
        return response()->json([
            'liked' => in_array($user->id, $array),
            'likeCount' => $post->likes,
        ]);
    }

    public function addComment($slug, Request $request) {
        $request->validate([
            'comments_detail' => 'required|string|min:1',
        ], [
            'comments_detail.required' => 'El campo de contenido está vacío',
            
        ]);
        
        // Recupera el post
        $post = Post::where('slug', $slug)->firstOrFail();
    
        // Recupera los comentarios existentes
        $comments = json_decode($post->comments_detail, true) ?? [];
    
        // Agrega el nuevo comentario al array
        $user = User::find(auth()->user()->id);
        $comment_detail = $request->comments_detail;
        $comments[] = [
            'user_id' => $user->id,
            'comments_detail' => $comment_detail,
            'created_at' => now(),
        ];
    
        // Codifica el array de comentarios de vuelta a JSON
        $post->comments_detail = json_encode($comments);
        $post->comments = $post->comments + 1;
    
        // Guarda los cambios en la base de datos
        $post->save();
    
        // Redirige de vuelta a la página de comentarios
        return redirect()->route('post.show', $slug);
    }

 
    


   

    
   
}
