<section class="menuMobile">
	<section id="data">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-6 pt-5 ">
					<div class="img">
						<img src="https://musicappevents.herokuapp.com/public/images/music.png" alt="">	
						<h1 class="color_white">My Menu</h1>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-12">
					<ul class="pt-5">
						<li class="noChildren">
							<a href="https://musicappevents.herokuapp.com/events">Home</a>
						</li>
						<li class="noChildren">
							<div class="d-flex justify-content-between">
								<a href="#">Main Events</a>
							    <i class="fa fa-plus" aria-hidden="true" @click="openSubMenu($event)"></i>
							</div>
							<ul class="secondLayer">
									<?php $index = 0;?>
									@foreach($eventsMenu as $event)
									  <li class="noChildren">
									  	<a href="/ticket/{{$event->id}}">{{$event->event_name}}</a>
									  </li>
									@endforeach
							</ul>
						</li>
						<li class="noChildren">
							<div class="d-flex justify-content-between">
								<a href="#">Services</a>
							    <i class="fa fa-plus" aria-hidden="true" @click="openSubMenu($event)"></i>
							</div>
							<ul class="secondLayer">
								<li class="noChildren">
									<a href="/query">Customer Services</a>
								</li>
								<li class="noChildren">
									<a href="/search">Search</a>
								</li>
							</ul>
						</li>
						<li class="noChildren mb-5">
							 <a href="/myeventshome" >be a vendor</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="cls">
			 <i class="fa fa-times" aria-hidden="true" @click="closeMenuMobile($event)"></i>
		</div>
	</section>
</section>