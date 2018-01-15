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
	<style>
		.head{
			background: url('https://musicappevents.herokuapp.com/public/images/{{$singer[0]->singerCover}}');
			background-size: cover;
    		background-repeat: no-repeat;
    		background-position: left;
    		@if($singer[0]->singerCover == 'singer3.jpg')
    		background-position: right;
    		@endif
		}
	</style>
</head>
<body>
	<section id="app">
<!--
    **
     * head of page
     *
     * shows an event with animation
     * 
 	**
 -->
<head> 
	
	<div class="container-fluid headImage ">
		<div class="row h-100">
			<div class="col-lg-12  mt-5 mb-5 head">
				<div class="body">
					<p class="title">{{$event->event_name}}</p>
					<p>{{$event->description}}</p>	
				</div>
				
			</div>
		</div><!-- row -->
	</div><!-- container -->
</head>

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
	 * display selected event
	 *
	 * using id on top
	 * 
	**
 -->
 <section class="event mt-5 mb-5">
 	<div class="container">
 		<div class="row">
 			<div class="col-lg-4">
 				<div class="imag">
 					<a href="/fullsize/{{$event->id}}">
 						<img src="https://musicappevents.herokuapp.com/public/images/{{$singer[0]->image}}" alt="">
 					</a>
 				</div>
 			</div> <!-- col-lg-4 -->
 			<div class="col-lg-4">
 				<h2 class="title color_white">
 					{{$event->event_name}}
 				</h2>
 				<p>
 					<span class="hover">Singers:</span>
 					<?php $counter = 0 ;?>
 					@foreach($singer as $singers)
	 					<?php $counter++ ;?>
	 					@if(count($singer) == 1 || (count($singer) - $counter) == 0)
	 						<a href="/singer/{{$singers->id}}">
	 							{{ $singers->singerName }}
	 						</a>
	 					@else
		 					<a href="/singer/{{$singers->id}}">
		 						{{ $singers->singerName }} ,	
		 					</a>
	 						
	 					@endif
 					@endforeach
 				</p>
 				<p>
 					<span class="hover">Date:</span>
 					{{$event->date}}
 				</p>
 				<p>
 					<span class="hover">Location:</span>
 					<a href="#">{{$location[0]->location}}</a>
 				</p>
 				<p class="mt-5">{{$event->description}}</p>
 			</div><!-- col-lg-8 -->
 		</div><!-- row -->
 	</div><!-- container -->
 </section>


 <!--
	**
	 * form to buy a ticket
	 *
	 * 
	 * 
	**
 -->
<form action="/ticket/purchase" method="post" class="container ticket" id="payment-form">
	{{csrf_field()}}
	<div class="row mb-5" >
		<div class="col-lg-12">
			<h1 class="ticketTitle color_white mb-5">
			Tickets
		</h1>
		</div>
		<div class="col-lg-12">
			<p>Buy Tickets for {{$event->event_name}}</p>
			<div class="mb-5">
				<p class="editText">
					Tickets are valid for one entry on, {{$event->date}}. Ticket prices are the same as at the show box office, 
					Ticket purchases are not refundable.
					You can print tickets at home or show your tickets on your phone at the show entrance.
					A confirming email with a Ticket Order ID will be sent to the ticket purchaser's email address.
					<span class="hover">Calculate expenses:</span>	
				</p>
			</div>	

		 <!--
			**
			 * Calculate ticket price
			 *
			 * Custom Component
			 * 
			**
		 -->

		<receive :adult="{{$tickets[0]->price_adult}}" :child="{{$tickets[0]->price_child}}"></receive>	
	
		</div>
	</div>
	<div class="row">
		<h1 class="col-lg-12 ticketTitle color_white mb-5">
			Buy Your Ticket
		</h1>
	@guest
	<p class="col-lg-12"><input type="name" name="name" placeholder="name" class="input"></p>
	<p class="col-lg-12"><input type="email" name="email" placeholder="email" class="input"></p>
	@else
	<p class="col-lg-12"><input type="name" name="name" placeholder="name" class="input" value="{{auth()->user()->name}}"></p>
	<p class="col-lg-12"><input type="email" name="email" placeholder="email" class="input" value="{{auth()->user()->email}}"></p>
	@endguest
	<p class="col-12 col-sm-8 col-md-6 col-lg-4 d-flex justify-content-around mt-3">
		<span>Adults: </span>
		<input type="number" name="adult"  class="input1">
		<span>children: </span>
		<input type="number" name="child" class="input1">
		<input type="hidden" value="{{$event->user_id}}" name="vendor_id">
		<input type="hidden" value="{{$event->id}}" name="event_id">
		<input type="hidden" value="{{$event->event_name}}" name="event">
		<input type="hidden" value="{{$tickets[0]->price_adult}}" name="adultP">
		<input type="hidden" value="{{$tickets[0]->price_child}}" name="childP">

	</p>
	<div class="col-lg-12">
		<div >
  			  <p for="card-element">
     			 <strong>Credit or debit card</strong>
    		  </p>
		      <div id="card-element">
		       <!-- a Stripe Element will be inserted here. -->
		      </div>
			    <!-- Used to display form errors -->
			    <div id="card-errors" role="alert"></div>
	  </div>
	  <br/>
  <button class="btn btn-warning bn-custom">Submit Payment</button>
  <payment></payment>
	</div>


	</div>
</form>

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
