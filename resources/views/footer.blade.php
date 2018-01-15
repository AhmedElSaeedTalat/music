
	<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-4 pt-5">
				 <h1 class="color_white"> Contact <strong>us</strong></h1>
				<p class="pt-2">Ellentesque eget mi nulla, ut ultrices enim. Etiam id erat bibendum metus tristique vestibulum sit amet ac mauris. Suspendisse eget nibh lectus.</p>
				<p class="pt-3"><span class="hover">Address:</span> Alexandria</p>
				<p><span class="hover">Email:</span> example.com</p>
				<p><span class="hover">Phone:</span> 09-995-8505</p>
			</div>
			<div class="col-lg-4 pt-5 mb-5">
				 <h1 class="color_white"> Latest Albums</h1>
				<div class="row">
					@foreach($latestAlbum as $album)
					<div class="col-lg-12">
						<p class="latest pt-2">
							<a href="/soundtrack/{{$album->id}}" >
								{{$album->name}}
							</a>
						</p>
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-lg-4 stagesFooter mt-5">
				<div class="row">
					<div class="col-12">
						<h1 class="color_white">Stages</h1>
					</div>
					 @foreach($locationFooter as $locations)
					<div class="col-lg-4 pt-5">
						<a href="/location/{{$locations->id}}">
							<div class="theStage">
								<img src="https://musicappevents.herokuapp.com/public/images/{{$locations->image}}" alt="">
								<span class="layover"></span>
							</div>
						</a>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</footer>