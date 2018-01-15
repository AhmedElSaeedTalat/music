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
     * head of page
     *
     * slider for services
     * 
 	**
 -->
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  <div class="carousel-inner h-100">
		    <div class="carousel-item active h-100">
		      <img class="d-block w-100" src="https://musicappevents.herokuapp.com/public/images/vendor3.jpeg" alt="First slide">
		      <div class="layerSlider"></div>
		      <div class="carousel-caption d-md-block">
			    <h5 class="silderTitle">Be one of Our Seller</h5>
			    <p class="sliderPar">One of the Best Open Source to Sell </p>
			    <p class="sliderPar">Events to the public</p>
			    <button class="btn">Be One Now</button>
			  </div>
		    </div>
		    <div class="carousel-item h-100">
		      <img class="d-block w-100" src="https://musicappevents.herokuapp.com/public/images/vendor2.jpg" alt="Second slide">
		      <div class="layerSlider"></div>
		      <div class="carousel-caption d-md-block">
			    <h5 class="silderTitle">Be one of Our Seller</h5>
			   <p class="sliderPar">One of the Best Open Source to Sell </p>
			    <p class="sliderPar">Events to the public</p>
			    <button class="btn">Be One Now</button>
			  </div>
		    </div>
		    <div class="carousel-item h-100">
		      <img class="d-block w-100" src="https://musicappevents.herokuapp.com/public/images/vendor1.png" alt="Third slide">
		      <div class="layerSlider"></div>
		      <div class="carousel-caption d-md-block">
			    <h5 class="silderTitle">Be one of Our Seller</h5>
			   <p class="sliderPar">One of the Best Open Source to Sell </p>
			    <p class="sliderPar">Events to the public</p>
			    <button class="btn">Be One Now</button>
			  </div>
		    </div>
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
</div>

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
     * form to send request to be a vendor
     *
     * body of page
     * 
 	**
 -->
 <section class="services mt-5 mb-5">
 	<div class="container">
 		<div class="col-12">
 			<h1 class="color_white">Services</h1>
 		</div>
 		<div class="row mt-5">
 			<div class="col-sm-6 col-lg-3 mb-5">
 				<div class="cover">
 					<div class="logo text-center">
 						<i class="fa fa-handshake-o" aria-hidden="true"></i>
 					</div>
 					<div class="body text-center">
 						<h3 >Easy Connection</h3>
 						<p class="mt-4">Easily Connect with the Client to sell Tickets Online</p>
 					</div>
 				</div>
 			</div><!-- col -->
 			<div class="col-sm-6 col-lg-3 mb-5">
 				<div class="cover">
 					<div class="logo text-center">
 						<i class="fa fa-globe" aria-hidden="true"></i>
 					</div>
 					<div class="body text-center">
 						<h3 >Wide Network</h3>
 						<p class="mt-4">Our Services are advertised and well known across the globe</p>
 					</div>
 				</div>
 			</div><!-- col -->
 			<div class="col-sm-6 col-lg-3 mb-5">
 				<div class="cover">
 					<div class="logo text-center">
 						<i class="fa fa-cc-visa" aria-hidden="true"></i>
 					</div>
 					<div class="body text-center">
 						<h3 >Payment System</h3>
 						<p class="mt-4">We provide payment system and flexible api to connect</p>
 					</div>
 				</div>
 			</div><!-- col -->
 			<div class="col-sm-6 col-lg-3 mb-5">
 				<div class="cover">
 					<div class="logo text-center">
 						<i class="fa fa-headphones" aria-hidden="true"></i>
 					</div>
 					<div class="body text-center">
 						<h3 >Customer Service</h3>
 						<p class="mt-4">Good caring customer service for all the clients 24/7</p>
 					</div>
 				</div>
 			</div><!-- col -->
 		</div>
 	</div>
 </section>
<!--
    **
     * form to send request to be a vendor
     *
     * body of page
     * 
 	**
 -->
 <section class="requestForm">
 	<div class="container">
 		<div class="row mb-5">
 			<div class="col-12">
 				<h2 class="color_white">
 					Start Your Journey and be our vendor
 				</h2>
 			</div>
 		</div>
		<div class="row">
			<div class="col-lg-5">
			<form action="/requestvendor" method="post">
				{{csrf_field()}}
				<p class="mb-5"><span class="pr-3 pb-3">Vendor:</span>
					<input type="text" name="name" placeholder="vendorName" required class="w-72 inputRequest"></p>
				<p  class="mb-5"><span class="pr-3 pb-3">Email:</span>
					<input type="email" name="email" placeholder="EmailAddress" required class="w-72 inputRequest"></p>
				<p  class="mb-5"><span class="pr-3 pb-3">Address:</span>
					<input type="text" name="address" placeholder="address" required class="w-72 inputRequest">
				</p>
				<p  class="mb-5"><span class="pr-3 pb-3">Selling Rate:</span><input type="number" name="rate" placeholder="selling rate per month" required  class="w-72 inputRequest"></p>
				<p class=""><input type="submit" value="Authorize" class="btn btn-warning"></p>
			</form>
		</div>
		<div class="col-lg-6"> 
			<div class="instructions">
				<p>Special Instructions</p>
				<p>
					Being a vendor will help you sell your tickets over one 
					of the most popular window in the red we will email you with 
					everything needed to connect to our app when you subscribe 
					Hoping you will enjoy our Services.
				</p>
			</div>
		</div>
		</div>
	</div>
 </section>

 <!--
    **
     * display latest  albums and locations
     *
     * Footer body
     * 
 	**
 -->

@include('footer')

	
</section>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://musicappevents.herokuapp.com/public/js/jquery.slim.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/tether.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/bootstrap.min.js"></script>
<script src="https://musicappevents.herokuapp.com/public/js/app.js"></script>

</body>
</html>