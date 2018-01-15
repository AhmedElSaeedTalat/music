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
			background: url('https://musicappevents.herokuapp.com/public/images/{{$singer->singerCover}}');
			background-size: cover;
    		background-repeat: no-repeat;
    		background-position: left;
    		@if($singer->singerCover == 'singer3.jpg')
    		background-position: right;
    		@endif
		}
		[v-cloak]
		{
			display: none
		}
	</style>
</head>
<body>
	<section id="app" v-cloak>
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
					<p class="title">{{$singer->event[0]->event_name}}</p>
					<p>{{$singer->event[0]->description}}</p>	
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

<!--
    **
     * show selected Singer
     *
     * main body
     * 
 	**
 -->
<section class="singerAlbums mt-5">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					
					<!--
					    **
					     * show small menu for the selected singer
					     *
					     * main body
					     * 
					 	**
					 -->
					<div class="col-12 ">
						<ul class="nav nav-tabs">
						  <li class="nav-item">
						    <a class="nav-link active" @click="active1" id="active1">Singer Bio</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" @click="active2" id="active2">Albums</a>
						  </li>
						<li class="nav-item">
						    <a class="nav-link" @click="active3" id="active3">Upcoming Eventss</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="cover" v-show="bio">
		<div class="container">
			<!--
			    **
			     * show singer biography
			     *
			     * main body
			     * 
			 	**
			 -->
			 <div class="row">
				<div class="col-lg-4 mt-5 pb-5">
					<img src="https://musicappevents.herokuapp.com/public/images/{{$singer->image}}" alt="">
				</div>
				<div class="col-lg-8 mt-5">
					<p><strong class="hover">Name:</strong> {{$singer->singerName}}</p>
					<p><strong class="hover">Date Of Birth:</strong> {{$singer->dateOB}}</p>
					<p><strong class="hover">Albums:</strong> {{count($singer->album)}}</p>
					<p class="mt-5 pr-3"> {{$singer->bio}}</p>
				</div>
			</div>
		</div>
	</section>
	<!--
	    **
	     * show singer's albums
	     *
	     * main body
	     * 
	 	**
	 -->
	<div class="container-fluid " v-show="albums">
		<div class="row">
			<?php $x = 0 ;?>
			@foreach($singer->album as $albums)
			<?php $x++ ;?>
			<div class="col-12" >
				<div class="row mb-3 <?php if($x % 2 == 0){echo 'b-black';}else{echo 'b-grey';}?>">
					<div class="col-4 col-md-2 d-flex align-items-center">
						<a href="/soundtrack/{{$albums->id}}"><img src="https://musicappevents.herokuapp.com/public/images/{{$albums->ablumCover}}" alt=""></a>
					</div>
					<div class="col-8 col-md-10">
						<p class="mt-5 mb-4"><strong class="hover">Album:</strong>{{$albums->name}}</p>
						<p class="mt-3 mb-4"><strong class="hover">Number of Songs:</strong>{{count($albums->songs)}}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>

	<!--
	    **
	     * show upcoming Events for teh singer
	     *
	     * main body
	     * 
	 	**
	 -->

	<div class="container eventSinger mt-5" v-show="event">
		<div class="row">
			<div class="col-12 mb-5">
				<div class="d-flex align-items-center justify-content-between">
					<div class="someBorder"></div>
					<div class="">
						<h1 class="color_white text-center">Upcoming Events</h1>
					</div>
					<div class="someBorder"></div>
				</div>
					
			</div>
		</div>
		<div class="row">
			@foreach($singer->event as $event)
			<div class="col-12 col-lg-6 mb-4">
				<div class="img">
					<a href="/ticket/{{$event->id}}#ticket">
						<img src="https://musicappevents.herokuapp.com/public/images/{{$event->location->image}}" alt="">
					</a>
					<a href="/ticket/{{$event->id}}#ticket" class="btn btn-warning button">Buy a ticket</a>
				</div>
				<h1 class="title color_white pt-3">{{$event->event_name}}</h1>
				<div class="d-flex justify-content-between">
					<div>
						<p>
							<i class="fa fa-map-marker hover" aria-hidden="true"></i>
							<a href="/location/{{$event->location->id}}">{{$event->location->location}}</a>
						</p>
					</div>
					<div>
						<p>
							<i class="fa fa-calendar hover" aria-hidden="true"></i>
							{{$event->date}}
						</p>
					</div>
				</div>
				<p>{{$event->description}}</p>
			</div>
			@endforeach
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
