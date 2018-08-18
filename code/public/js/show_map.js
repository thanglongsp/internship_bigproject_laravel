      function initMap() {
      	var directionsService = new google.maps.DirectionsService;
      	var directionsDisplay = new google.maps.DirectionsRenderer;
      	var map = new google.maps.Map(document.getElementById('map'), {
      		zoom: 20,
      		center: {
      			lat: 21.004133, 
      			lng: 105.846011
      		}
      	});
      	directionsDisplay.setMap(map);
      	calculateAndDisplayRoute(directionsService, directionsDisplay);
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) { 
      	var points = $('#waypoints').text().split(".");
      	var waypts = [];
      	var travel = {1:"DRIVING", 2:"WALKING"};
      	for (var i = 0; i < points.length - 1; i++) {
              // alert(points[i]);
              waypts.push({
               location: points[i],
               stopover: true
              });
        }
        console.log(waypts);
        console.log(document.getElementById('start').value);
        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('start').value,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: travel[1]
        }, function(response, status) {
          if (status === 'OK') {
           directionsDisplay.setDirections(response);
           var route = response.routes[0];
           var summaryPanel = document.getElementById('directions-panel');
           summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
            	var routeSegment = i + 1;
            	summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            	'</b><br>';
            	summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
            	summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
            	summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
           window.alert('Directions request failed due to ' + status);
         }
       });
    }

  // Lấy tọa độ check in ... 

  getLocation();

  function getLocation() {
    navigator.geolocation.getCurrentPosition(showPositionCheckin);
  }

  function showPositionCheckin(position) {
    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
    var geocoder = new google.maps.Geocoder;

    geocoder.geocode({'location': latlng}, function(results,status) {
      var checkin_location = document.getElementsByName('name_place');
      for(i = 0; i < checkin_location.length; i++){
        checkin_location[i].value = results[0].formatted_address;
        console.log(checkin_location[i].value);
      }
      // console.log(document.getElementsByName('name_place'));
    });
  }