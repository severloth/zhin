<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('./css/register_styles.css')}}">
    <title>Register</title>
    @vite('resources/css/app.css')
    

</head>
<body>

    
<h1>ZHIN</h1>
<h2>Share your thoughts</h2>  

@if(session('message'))
<div id="alertas">


    <div class="alert alert-danger">
        {{session('message')}}
    </div>
    </div>
    
@endif

    
    <div class="container">
        <div id="register">
            <div id="register_form">
            <form action="{{ url('/user/create') }}">
                @csrf

            <h3>Registrate</h3>
            <label for="name">Nombre</label>
            <input type="text" name="name" required>
            <label for="lastname">Apellido</label>
            <input type="text" name="lastname" required>
            <label for="username">Username</label>
            <input type="text" name="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Crear usuario</button>




    </form>
    <a href="{{route('login')}}">Iniciar Sesión</a>

            </div>
        </div>
    </div>
    
    
</body>
</html>