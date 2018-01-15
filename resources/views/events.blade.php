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
			background: url('https://musicappevents.herokuapp.com/public/images/{{$singerImage[0]}}');
			background-size: cover;
    		background-repeat: no-repeat;
    		background-position: left;
    		@if($singerImage[0] == 'singer3.jpg')
    		background-position: right;
    		@endif
		}
		[v-cloak]
		{
			display: none;
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
     * body of page
     *
     * display different events
     * 
 	**
 -->

<section class="events mt-5">
	<div class="container"  action="/ticket" method="post">
		<div class="row">
			<div class="col-md-8">
				<div class="row" >
					<div class="col-sm-6 col-md-6 col-lg-4 mb-5" v-for="event in events">
						<div class="image">
							<a :href="'/ticket/' + event.id" >
								<img :src="'https://musicappevents.herokuapp.com/public/images/'+event.singer[0].image" alt="">
							</a>
							<a :href="'/ticket/' + event.id">
								<div class="layer">
									<p class="date">@{{event.date}}</p>
									<p class="location">
										@{{event.location.location}}
									</p>
								</div>
						    </a>
						</div>

						<p>
							<a  :href="'/ticket/' + event.id" class="title pt-3">@{{event.event_name}}</a>
						</p>
						<p>
							<a :href="'/ticket/' + event.id">
								@{{event.description}}
							</a>
						</p>
						<p>
							<a :href="'/ticket/' + event.id" class="btn btn-warning button">buy ticket</a>
						</p>
					</div>
					<!--
					    **
					     * paginate events
					     *
					     * display different events
					     * 
					 	**
					 -->
					<div class="col-lg-12 text-center">
						@for($i = 1 ; $i <= $countPages ; $i++)
						<span 
						class="pagination1"
						@click="paginate($event,`{{$i}}`)"
						>{{$i}}</span>
						@endfor
					</div>
					<!--
					    **
					     * body of page
					     *
					     * display popular singers passed 3 singers
					     * 
					 	**
					 -->
 					<div class="col-lg-12 singers mt-5 pb-3">
 						<h2 class="mt-3  color_white">Popular Singers</h2>
 					</div>
 					@foreach($singers as $singer)
 					<div class="col-sm-6 col-md-4 singers1 mb-5 ">
 						<div class="image">
 							<a href="/singer/{{$singer->id}}">
 								<div class="layer"></div>
 								<img src="https://musicappevents.herokuapp.com/public/images/{{$singer->image}}" alt="">
							</a>
 						</div>
						<span class="singerName">
							<a href="/singer/{{$singer->id}}">{{$singer->singerName}}</a>
						</span>
 					</div>
 					@endforeach
				</div>
				<!--
				    **
				     * body of page
				     *
				     * display an album
				     * 
				 	**
				 -->
				<div class="row mt-5 album">
					<div class="col-lg-12">
 						<h2 class="color_white">Album Of the week</h2>
 					</div>
 					<div class="col-lg-4 mt-4">
 						<div class="image">
 							<div class="layerx">
 								<p class="mt-5">{{$album[0]->name}}</p>
 								<p class="mt-3">{{$album[0]->singers[0]->singerName}}</p>
 							</div>
 								<img src="https://musicappevents.herokuapp.com/public/images/{{$album[0]->ablumCover}}" alt="">
 							</div>
 					</div>
				
				<!--
				    **
				     * body of page
				     *
				     * display related songs to the album
				     * 
				 	**
				 -->

 					<div class="col-lg-7 col-lg-offset-1 mt-5">
 						<?php $index = 0 ;?>
 						@foreach ($album[0]->songs as $key => $value)
 						<?php $index++ ;?>
 						<?php if($index == 3){break;}?>
 						<audio id="player{{$index}}" >
	 						 <source src="https://musicappevents.herokuapp.com/public/sound/{{$value->path}}" type="audio/mpeg">
							Your browser does not support the audio element.
						</audio>
						<div class="row">
							<div class="col-lg-12">
 								<p><strong>Song:</strong>{{$value->name}}</p>
 							</div>
						</div>
 						<div class="row d-flex align-items-center soundTrack mb-3">	
							<div class="col-1">	
								<i class="fa fa-play"
								   aria-hidden="true" 
								    @click="play(`{{$index}}`)"
								      ></i>
								<i 
								class="fa fa-pause" 
								aria-hidden="true"  
								@click="pause(`{{$index}}`)" 
								></i>		
							</div>
							<div class="col-8">
								<input type="range" id="seek-bar" name="seek"  @change="seeking(`{{$index}}`)" class="seek">
							</div>
							<div class="col-3">	
								<div class="volume">	
									
									<input 
									type="range" 
									id="volume" 
									v-model="volume" 
									min="0" 
									max="1"
									step=0.1
									  @change="changeVol(`{{$index}}`)"
									class="vol mt-5">
									<i class="fa fa-volume-up" aria-hidden="true"></i>
									<i class="fa fa-volume-down" aria-hidden="true" ></i>
									<i class="fa fa-volume-off" aria-hidden="true"></i>
								</div>
							</div>
 						</div>
 						@endforeach
 						<a href="/soundtrack/{{$album[0]->id}}" class="moreSongs">more songs</a>
 					</div>
				</div><!-- row -->
			</div><!--  col-8 -->
			<!--
			    **
			     * sidebar 
			     *
			     * display lists and adverts
			     * 
			 	**
			 -->
			<div class="col-md-4 col-lg-3 col-lg-offset-1 " >
				<div class="row borders ">
					<!--
					    **
					     * sidebar 
					     *
					     * display special note for customers
					     * 
					 	**
					 -->
					<div class="col-lg-12 bg_hover arrow">
						<h2 class="mt-3 ">
							Special note
						</h2>
					</div>
					<div class="col-lg-12">
						<p class="pt-3">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim harum repudiandae 
						repellendus
						</p>
					</div>
				</div>
				<!--
				    **
				     * sidebar 
				     *
				     * display list of popular stages
				     * 
				 	**
				 -->
				<div class="row borders pb-5 mt-5">
					<div class="col-lg-12 bg_hover arrow">
						<h2 class="mt-3 ">
							Popular Stages 
						</h2>
					</div>
						@foreach($location as $locations)
						<div class="col-lg-6 mt-5">
							<a href="/location/{{$locations->id}}">
							<div class="theStage">
								
									<img src="https://musicappevents.herokuapp.com/public/images/{{$locations->image}}" alt="">
								
								<span class="layover"></span>
							</div>
						</a>
					</div>
					<div class="col-lg-6 mt-5" >
						<a href="/location/{{$locations->id}}" class="customSize">{{$locations->location}}</a>
					</div>
					@endforeach
				</div>
				<!--
				    **
				     * sidebar 
				     *
				     * display adverts
				     * 
				 	**
				 -->
				<div class="col-lg-12">
					<div class="Advert">
						<div id="carouselExampleSlidesOnly" class="carousel slide h-100" data-ride="carousel">
						  <div class="carousel-inner h-100">
						    <div class="carousel-item active h-100">
						    	<div class="layout"></div>
						      <img class="d-block w-100 h-100" src="https://musicappevents.herokuapp.com/public/images/michael.jpg" alt="First slide">
						      <div class="carousel-caption eventing d-md-block">
							    <h5>Get First And Get Discount</h5>
							    <p>50% Off All services</p>
							  </div>
						    </div>
						    <div class="carousel-item">
						    	<div class="layout"></div>
						      <img class="d-block w-100" src="https://musicappevents.herokuapp.com/public/images/model.jpg" alt="Second slide">
						      <div class="carousel-caption eventing d-md-block">
							     <h5>Get First And Get Discount</h5>
							    <p>50% Off All services</p>
							  </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</section>

<!--
    **
     * include latest albums
     *
     * footer of page
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
