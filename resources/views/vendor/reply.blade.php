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
<body class="vendorRequestReplyBody">

<section id="app" class="mt-4">
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
	 * the menu
	 *
	 * lead to different pages
	 * 
	**
 -->

	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
				<div class="info">
					Thanks for your request, the request will be considered and we will email you with the provided credentials soon....
					<a href="/myeventshome" style="border-bottom: 1px solid;" class="hover">return back</a>
				</div>
		</div>
		</div>
	</div>

<!--
    **
     * 
     *
     * footer of page
     * 
 	**
 -->

<section style="margin-top: 36rem">
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