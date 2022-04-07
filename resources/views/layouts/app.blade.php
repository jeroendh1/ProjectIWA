<!DOCTYPE html>
<html>
<head>
    <title>IWA</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="../../js/app.js"></script>
    <script src="../../js/bootstrap.js.js"></script>
</head>
<body>

@include('inc.navbar')
@yield('content')


</body>
</html>
