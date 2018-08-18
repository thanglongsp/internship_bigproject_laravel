<!doctype html>
<html lang="en"> 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Let's go</title>
	<base href="{{asset('')}}">
	<link rel="icon" type="image/png" href="{{asset('images/logos/smile.png')}}"/>
	<link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	<script src="{{ asset('js/app.js') }}"></script> 
	<script src="{{ asset('js/show_map.js') }}"></script>
	<script src="{{ asset('js/data.js') }}"></script>
	<script src="{{ asset('js/datepicker.js') }}"></script>
	<script src="{{ asset('js/jquery.datetimepicker.full.min.js')}}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxouibC2C2AIc9VjH3DuziTdSEvPOIthQ&libraries=visualization&callback=initMap" async defer></script>
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
	<link rel="stylesheet" href="{{asset('css/jquery.datetimepicker.min.css')}}">
</head>
<body> 
	@include('layouts.header')
	<!-- #header -->
	<div class="page-body">
		@yield('content')
	</div>
	@include('layouts.footer')
</body>

</html>