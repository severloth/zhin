<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('./css/post_styles.css')}}">


</head>
<div class="post-header">
        <div class="post-header-info">
            
            <!--SHOW THE USERNAME OF THE CREATOR OF THE POST--> 
            <!--HIDE OWNERPOST-->

            <p style="display:none">{{$ownerPost = App\Models\User::find($post->user_id)}}</p>
            <h3>{{$ownerPost->name}}</h3>
            <p><span>@</span>{{$ownerPost->username}}<p>
            <p>{{$post->created_at->diffForHumans()}}</p>
          
        </div>
        </div>
    </div>
    <div class="post-content">
        <p style="margin-left:20px;">{{$post->content}}</p>
    </div>
    <div class="post-footer">
        <div class="post-footer-likes">
            <!-- <a href="#" onclick="showLikes()"><p>{{$post->likes}} likes</p></a> -->
           
            <span id="like-count-{{ $post->slug }}">{{ $post->likes }}</span>

            <button class="like-button {{ $post->likedByUser() ? 'liked' : '' }}" data-post-slug="{{ $post->slug }}">
    @if ($post->likedByUser())
        <i class="fas fa-heart text-danger"></i> <!-- Icono de corazón lleno (rojo) -->
    @else
        <i class="far fa-heart"></i> <!-- Icono de corazón vacío -->
    @endif
</button>
        </div>
        <div class="post-footer-comments">
            <p>{{$post->comments}} comments</p>
        </div>
        
    </div>
    <p> 
     
        <?php $array = json_decode($post->liked_by); ?>
        @if($array == null)
            <?php $array = []; ?>
        @endif


    </p>


