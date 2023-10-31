<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZHIN</title>
    <link rel="stylesheet" href="{{url('./css/main_styles.css')}}">
    <link rel="stylesheet" href="{{url('./css/post_styles.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>


<nav>
<aside>

    <h2>Hola, {{$usuario->name}}</h2>

    <ul>
       <a href="#"><li>Home</li></a>
       <a href="#"><li>Search</li></a>
       <a href="#"><li>Shorts</li></a>
       <a href="#"><li>Account</li></a>
       <a href="#"><li>Settings</li></a>
  
    </ul>
</aside>
</nav>

<nav>
<div id="right-aside">

    <!--SHOW ALL USERS IN THE SYSTEM--> 
    <h3>Personas usando ZHIN</h3>
    <ul>
        @foreach($allUsers as $user)
            <a href="#"><li>{{$user->name}}</li></a>
        @endforeach
    </ul>

</div>
</nav>

<div id="create-post">
    <form action="{{url('/post/create')}}">
        @csrf
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <button type="submit">Post</button>
    </form>

</div>


<div id="post-container">
    
@foreach($posts as $post)

<a href="{{url('/show/'.$post->slug)}}" class="post-a">
<div class="post">

@include('posts._post')

</a>


@endforeach
</div>

<div id="paginator" >
    {{$posts->links()}}
</div>


<div id="overlay">
    
    <div id="liked_by">
        <div id="closeOverlay">
            <a href="#" onclick="closeOverlay()">X</a>
        </div>
        <h2>Le gusta a:</h2>
        <div id="liked_by_users">
            <ul>
                
        
            </ul>
        
    </div>
    </div>
    
    
    </div>




<div id="error-message" style="color: red;"></div>
<div class="notification" id="like-notification">Has likeado un post</div>


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