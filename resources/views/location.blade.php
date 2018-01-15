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
</head>
<body>
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
@include('menuMobile')

<!--
    **
     * display selected location
     *
     * body of page
     * 
 	**
 -->
<section class="location1 mt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<img src="https://musicappevents.herokuapp.com/public/images/{{$location->image}}" alt="">
			</div>
			<div class="col-lg-8 mt-3">
				<p><strong class="hover">Location:</strong>{{$location->location}}</p>
				<p><strong class="hover">Address:</strong>{{$location->address}}</p>
				<p class="mt-5">{{$location->description}}</p>
			</div>
		</div>
	</div>
</section>
<!--
    **
     * 
     *
     * footer of page
     * 
 	**
 -->

@include('footer')

</body>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>
</html>