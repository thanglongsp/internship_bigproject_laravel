
		<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" data-interval="4000">
			<div class="carousel-inner">
				@foreach($slides as $slide)
					<div class="carousel-item {{($slide->id==1)?'active':''}}">
						<img class="d-block w-100" src="{{asset('images/slides/'.$slide->banner)}}" height="400px" />
					</div>
				@endforeach
			</div>
		</div>