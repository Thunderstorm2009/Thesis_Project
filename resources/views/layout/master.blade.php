<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ url('home') }}">Trial Cold PVP</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="{{url('profile/Daniel')}}">daniel</a></li>
      <li><a href="{{url('profile/Marvin')}}">marvin</a></li>
      <li><a href="{{url('profile/Musyadad')}}">musyadad</a></li>
      <li><a href="{{url('profile/Alex')}}">alex</a></li>
      <li><a href="{{url('profile/Fawzil')}}">fawzil</a></li>
    </ul>
  </div>
</nav>
  
@yield('container')

</body>
</html>
