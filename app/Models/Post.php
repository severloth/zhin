<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'content',
        'slug',
        'user_id',
        'likes',
        'comments',
        'comments_detail'
    ];

    //liked by user
    public function likedByUser()
    {
        $user = User::find(auth()->user()->id);
        $array = json_decode($this->liked_by, true);
        

        if (is_null($this->liked_by)) {
            $array = [];
        }

        if (in_array($user->id, $array)) {
            return true;
        } else {
            return false;
        }
    }

}
