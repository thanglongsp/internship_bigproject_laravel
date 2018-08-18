var markers = [];

function addTableRow() {
    var start       = document.getElementById('start').value;
    var start_time  = document.getElementById('start_time').value; 
    var end         = document.getElementById('end').value;
    var end_time    = document.getElementById('end_time').value;
    var action      = document.getElementById('action').value;
    var plan_name   = document.getElementById('plan_name_tamp').value;
    var file = document.querySelector('input[type=file]').files[0];

    if(start == '' || start_time == '' || end_time == '' || action == '' || plan_name == '')
    {
        document.getElementById('notify').innerHTML = "*Bạn phải điều đầy đủ các trường( địa điểm kết thúc có thể trống)";
        if(file == null) document.getElementById('notify').innerHTML = "*Bạn chưa có banner cho plan";
    }
    else{
        var table = document.getElementById("tBody");
        var row   = table.insertRow(0);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);   
        var cell6 = row.insertCell(5);
        cell1.innerHTML = document.getElementById('start').value;
        cell2.innerHTML = document.getElementById('start_time').value;
        cell3.innerHTML = document.getElementById('end').value;
        cell4.innerHTML = document.getElementById('end_time').value;
        cell5.innerHTML = document.getElementById('mode').value;
        cell6.innerHTML = document.getElementById('action').value;
        document.getElementById('start').value = document.getElementById('end').value;
        document.getElementById('start_time').value = '';
        document.getElementById('end').value = '';
        document.getElementById('end_time').value = '';
        document.getElementById('mode').value = '';
        document.getElementById('action').value = '';

        clearMarkers();
    }
}

// Hàm xóa row của bảng roads
function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address);
        } else {
            updateMarkerAddress('Cannot determine address at this location.');
        }
    });
}

// Khởi tạo map
function initMap() {
    var directionsDisplay = new google.maps.DirectionsRenderer({
        draggable: true,
        map: map
    });

    directionsDisplay.addListener('directions_changed', function() {
        var startAddress = directionsDisplay.getDirections().routes[0].legs[0].start_address;
        var endAddress = directionsDisplay.getDirections().routes[0].legs[0].end_address;
        document.getElementById('start').value = startAddress;
        document.getElementById('end').value = endAddress;
    });

    var directionsService = new google.maps.DirectionsService;
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: {
            lat: 21.004133,
            lng: 105.846011
        }
    });

    directionsDisplay.setMap(map);

    google.maps.event.addListener(map, 'click', function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        document.getElementById('latlng').value = lat + ',' + lng;
        geocodeLatLng(geocoder, map, infowindow);
    });

    calculateAndDisplayRoute(directionsService, directionsDisplay);
    document.getElementById('mode').addEventListener('change', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
}

// Hàm chuyển đổi tọa độ sang tên địa danh
function geocodeLatLng(geocoder, map, infowindow) {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var latlng = {
        lat: parseFloat(latlngStr[0]),
        lng: parseFloat(latlngStr[1])
    };
    var start = document.getElementById('start').value;
    geocoder.geocode({
        'location': latlng
    }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                map.setZoom(11);
                if (document.getElementById('start').value == 0) {
                    var marker = new google.maps.Marker({
                        draggable: true,
                        position: latlng,
                        map: map
                    });
                    markers.push(marker);
                    marker.set("id", 1);
                } else {
                    var marker = new google.maps.Marker({
                        draggable: true,
                        position: latlng,
                        map: map
                    });
                    markers.push(marker);
                    marker.set("id", 2);
                }
                // alert(marker.getPosition());
                google.maps.event.addListener(marker, 'dragend', function() {
                    // var location = marker.getPosition().lat()+','+marker.getPosition().lng();
                    geocoder.geocode({
                        latLng: marker.getPosition()
                    }, function(responses) {
                        if (responses && responses.length > 0) {
                            var val = marker.get("id");
                            if (val == 1) document.getElementById('start').value = responses[0].formatted_address;
                            else document.getElementById('end').value = responses[0].formatted_address;
                        }
                    });
                    //document.getElementById('start').value = geocodePosition(location);
                });
                if (start == 0) document.getElementById('start').value = results[0].formatted_address;
                else document.getElementById('end').value = results[0].formatted_address;
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

// Hàm tìm đường đi giữa 2 điểm.
function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    var selectedMode = document.getElementById('mode').value;
    directionsService.route({
        origin: document.getElementById('start').value,
        destination: document.getElementById('end').value,
        travelMode: google.maps.TravelMode[selectedMode]
    }, function(response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
        }
    });
}

