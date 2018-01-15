<menu>
	<div class="container h-100">
		<div class="row h-100  d-flex align-items-center menuContent">
			<div class="col-8">
				<ul class="d-flex align-items-center mb-0">
					<li class="">
						<a href="https://musicappevents.herokuapp.com/events">Home</a>
					</li>
					<li class="">
						<a href="#">Main Events</a>
						<ul class="dropMenu">
							@foreach($eventsMenu as $event)
							<li>
								<a href="/ticket/{{$event->id}}">{{$event->event_name}}</a>
							</li>
							@endforeach
						</ul>
					</li>
					<li>
						<a href="#">Services</a>
						<ul class="dropMenu">
							<li>
								<a href="/query">Customer Services</a>
							</li>
							<li>
								<a href="/search">Search</a>
							</li>
						</ul>
					</li>
					<li class="">
						 <a href="/myeventshome" >be a vendor</a>
					</li>
				</ul>
			</div>
			<div class="col-4 text-right">
				@guest
				<span class="color_white pr-2">
					<a href="/login" class="pr-2">sign-in</a>|
				</span>
				<span>
					<a href="/register">sign-up</a>
				</span>
				@else
				<li class="dropdown">
				@if(auth()->user()->role == "admin")
							<a href="/home">{{ Auth::user()->name }}</a>
				@else
				<a href="#">{{ Auth::user()->name }}</a>
				@endif
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                             </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="/loggingout" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                      </li>
				@endguest
			</div>
		</div>
		<div class="row burgerMenu h-100">
			<div class="container h-100">
				<div class="row h-100"> 
					<div class="col-8 h-100  d-flex align-items-center">
						<ul class="d-flex align-items-center mb-0">
							<li class="">
								<a href="https://musicappevents.herokuapp.com/events">Home</a>
							</li>
						</ul>
					</div>
					<div class="col-4 h-100 d-flex align-items-center">
						<i class="fa fa-bars" aria-hidden="true" @click="openSmallMenu"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</menu>