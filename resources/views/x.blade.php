<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="{{ Request::getHost() }}:3000/socket.io/socket.io.js"></script>
</head>
<body>
	<div id="app">
	

<socket></socket>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.0/socket.io.js"></script>
<script>
	 var socket = io();
</script>	
<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>