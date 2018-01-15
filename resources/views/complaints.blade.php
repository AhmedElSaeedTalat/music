<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/app.css">
	<link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/css/index.css">
    <link rel="stylesheet" href="https://musicappevents.herokuapp.com/public/font-awesome-4.7.0/css/font-awesome.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
   
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

</head>
<body class="requestVendorsBody">
<div id="app">
	<div></div>
	<admin authen="{{auth()->user()->name}}"></admin>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>
</body>
</html>
