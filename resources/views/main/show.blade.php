<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('./css/post_styles.css')}}">
    <link rel="stylesheet" href="{{url('./css/main_styles.css')}}">
    <link rel="stylesheet" href="{{url('./css/show_styles.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{url('./js/main.js')}}"></script>

 
    <title>ZHIN | Post</title>
</head>
<body>

<nav>
<aside>

    <h2>Hola, {{$user->name}}</h2>

    <ul>
       <a href="{{url('/')}}"><li>Home</li></a>
       <a href="#"><li>Search</li></a>
       <a href="#"><li>Shorts</li></a>
       <a href="#"><li>Account</li></a>
       <a href="#"><li>Settings</li></a>
  
    </ul>
</aside>
</nav>

    <div id="post-container">
        <div class="post">
            <div class="post-author">
            <p style="display:none">{{$ownerPost = App\Models\User::find($post->user_id)}}</p>
                <div class="post-author-avatar">
                    <img src="{{url('./img/avatar.png')}}" alt="">
                </div>
                <div class="post-header-info">
                <p style="display:none">{{$ownerPost = App\Models\User::find($post->user_id)}}</p>
            <h3>{{$ownerPost->name}}</h3>
            <p><span>@</span>{{$ownerPost->username}}<p>
            <p>{{$post->created_at->diffForHumans()}}</p>
                </div>
            </div>
            <div class="post-content">
                <p>{{$post->content}}</p>
            </div>
            <div class="post-footer">
                <div class="post-footer-likes">
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
        </div>
        <div class="comments-section">
    <h2>Comentarios</h2>
    <form id="comment-form" action="{{url('/post/comment/'.$post->slug)}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="comment"></label>
            <textarea id="comment" name="comments_detail" rows="3" placeholder="Añade un comentario: "></textarea>
        </div>
        <button type="submit">Comentar</button>
    </form>

    <!-- Lista de comentarios existentes -->
    <ul id="comment-list">
        @if($comments != null)
        @foreach($comments as $comment)
            <li>
            <div class="comment-author">
                <img src="{{url('./img/comment.png')}}" alt="comment">
            <p style="display:none">{{$ownerComment = App\Models\User::find($comment['user_id'])}}</p>
              
            <strong>{{ $ownerComment->name }} {{ $ownerComment->lastname }}</strong><span>@</span>{{ $ownerComment->username }}
               
            </div>
            @if (isset($comment['comments_detail']))
                <div class="comment-content">
                    {{ $comment['comments_detail'] }}
                </div>
            @endif
              
                <div class="comment-timestamp">
                {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                </div>
            </li>
        @endforeach
        @endif
    </ul>
</div>
    </div>

    <div id="error-message" style="color: red;"></div>
<div class="notification" id="like-notification">Has likeado un post</div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{url('./js/main.js')}}"></script>    
    <script>
    function showLikes(){
        const overlay = document.getElementById('overlay');
        const liked_by = document.getElementById('liked_by');
        overlay.style.display = 'flex';
        liked_by.style.display = 'flex';
    }

    function closeOverlay(){
        const overlay = document.getElementById('overlay');
        const liked_by = document.getElementById('liked_by');
        overlay.style.display = 'none';
        liked_by.style.display = 'none';
    }


</script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $('.like-button').click(function () {
        var button = $(this);
        var postSlug = button.data('post-slug');
        
        $.ajax({
            url: '{{ url('/post/like') }}/' + postSlug,
            type: 'GET',
            success: function (response) {
                // Cambia la clase del botón de like según la respuesta del servidor
                if (response.liked) {
                    button.find('i').removeClass('far').addClass('fas text-danger');
                    
                    // Muestra la notificación solo cuando se da like
                    showNotification('Has likeado un post');
                } else {
                    button.find('i').removeClass('fas text-danger').addClass('far');
                }
                
                // Actualiza el contador de likes en la vista
                $('#like-count-' + postSlug).text(response.likeCount);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
    
});



// Función para mostrar la notificación
function showNotification(message) {
    const notification = document.getElementById('like-notification');
    notification.innerText = message;
    notification.style.display = 'block';

    // Ocultar la notificación después de un tiempo (por ejemplo, 3 segundos)
    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000); // 3000 milisegundos = 3 segundos
}





 
</script>
</body>
</html>