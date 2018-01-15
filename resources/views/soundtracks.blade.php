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
			background: url('https://musicappevents.herokuapp.com/public/images/{{$album->singers[0]->singerCover}}');
			background-size: cover;
    		background-repeat: no-repeat;
    		background-position: left;
    		@if($album->singers[0]->singerCover == 'singer3.jpg')
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
					<p class="title">{{$album->singers[0]->event[0]->event_name}}</p>
					<p>{{$album->singers[0]->event[0]->description}}</p>
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
     * display latest  albums and locations
     *
     *  body
     * 
 	**
 -->		
 <section class="albumsTracks">
 	<div class="musicLogo">
		<img src="https://musicappevents.herokuapp.com/public/images/music.png" alt="" class="img-fluid"> 
	</div>
	<section class="songs mt-5">
 	<div class="container">
 		<div class="row adjustMargin d-none d-sm-block">
 			<div class="col-12 mb-3">
				<div class="row ">
					<div class="col-2"></div>
						<div class="col-1 d-flex justify-content-center align-items-center trackBorders">	
						<p class="mb-0 hover">Play</p>				
					</div>
					<div class="col-2 d-flex justify-content-center align-items-center trackBorders">
						<p class="mb-0 hover">Album Name</p>
					</div>
					<div class="col-2  d-flex justify-content-center align-items-center trackBorders">
						<p class="mb-0 hover">Song Name</p>
					</div>
					<div class="col-2 d-flex justify-content-center align-items-center trackBorders">
						<p class="mb-0 hover">Genre</p>
					</div>
					<div class="col-2 d-flex justify-content-center align-items-center ">
						<p class="mb-0 hover">Download</p>
					</div>
				</div>
			</div>
 		</div>
 		<div class="row mt-5">
 			<?php $index = 0;?>
 			@foreach($album->songs as $song)
 			<?php $index++;?>
 			<audio id="player{{$index}}"  >
					 <source src="https://musicappevents.herokuapp.com/public/sound/{{$song->path}}" type="audio/mpeg">
					Your browser does not support the audio element.
			</audio>
				<div class="col-12 mb-5">
					<div class="row adjustMargin2">
						<div class="col-2"></div>
 							<div class="col-sm-1 d-flex justify-content-center align-items-center trackBorders">	
								<span class="play">
								<i class="fa fa-play"
							   aria-hidden="true" 
							    @click="play(`{{$index}}`)"
						    	 ></i>
								<i 
							class="fa fa-pause" 
							aria-hidden="true"  
							@click="pause(`{{$index}}`)" 
							></i>		
							</span>				
						</div>
						<div class="col-sm-2 d-flex justify-content-center align-items-center trackBorders">
							<p>{{$album->name}}</p>
						</div>
						<div class="col-sm-2 d-flex justify-content-center align-items-center trackBorders ">
							<p>{{$song->name}}</p>
						</div>
						<div class="col-sm-2 d-flex justify-content-center align-items-center trackBorders">
							<p>{{$song->genre}}</p>
						</div>
						<div class="col-sm-2 d-flex justify-content-center align-items-center ">
							<a href="/download/{{$song->id}}" target="_blank"><span class="Download"><i class="fa fa-arrow-down hover" aria-hidden="true"></i></span></a>
						</div>
					</div>
				</div>
			@endforeach
 		</div>
 	</div>
 </section>
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