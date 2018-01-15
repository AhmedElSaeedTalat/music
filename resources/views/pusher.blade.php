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
</head>
<body id="chatBodyPage">
<section id="app">

<!--
    **
     * the menu
     *
     * lead to different pages
     * 
 	**
 -->

@include('menu')


<section class="chatFacade">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-10 col-sm-6 col-lg-3  chat" @click='showChat' v-show="chatFacade">
				<div class="body">
					<h1 class="color_white text-center w-100">Queries Window</h1>
					<h1 class="color_white w-100 link-Style">Click to activate Chat</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<!--
    **
     * queries
     *
     * query window for the customers
     * 
 	**
 -->

<pusher user="{{auth()->user()->name}}" v-show="chatWindow"></pusher>

<!--
    **
     * include latest albums
     *
     * footer of page
     * 
 	**
 -->

<section id="chatFooter">
   @include('footer') 
</section>


</section>


<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>

</body>
</html>

