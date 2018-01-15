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


<!--
    **
     * thank you message with link back
     *
     *  body
     * 
 	**
 -->

<div class="container">
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
				<div class="info">
					Thanks for your Purchase, You we will be emailed  with the Tickets if a few minutes....
					<a href="/ticket/{{$event_id}}" style="border-bottom: 1px solid;" class="hover">return back</a>
				</div>
		</div>
		</div>
	</div>

<!--
    **
     * display latest  albums and locations
     *
     * Footer body
     * 
 	**
 -->

<section style="margin-top: 15rem">
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
