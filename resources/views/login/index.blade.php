<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('./css/login_styles.css')}}">
    <title>Document</title>
    @vite('resources/css/app.css')
    
   
</head>

<body>
<h1>ZHIN</h1>
<h2>Share your thoughts</h2>  

@if(session('message'))
<div id="alertas">
  <div class="alert alert-success">
    {{session('message')}}
  </div>
</div>
@endif

  <div class="container">
    <div id="login">
      <div id="login_form">
        <form action="{{url('/login')}}" method="POST">
        @csrf
        <h3>Iniciar sesión ahora</h3>
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="">

        <label for="password">Password</label>
        <input type="password" name="password">

        <button type="submit">Iniciar sesión</button>

        </form>

       
        <a href="{{route('user.create')}}">Crear cuenta</a>

      </div>
    </div>
  </div>
    
</body>
</html>