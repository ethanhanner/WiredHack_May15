<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      ul {
	      list-style: none;
	      
      }
      .firstHeading {
	      margin-left: 10px;
      }
      #map-canvas{
	      position: relative;
	      top: 100px;
	      margin: 0 auto;
	      width: 50%;
	      height: 50%;
	      border: 1px solid rgba(0,0,0,0.2);
	      border-radius: 5px;
      }
    </style>
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>


var map;
function initialize() {
	//Setup Google geocoder
	var geocoder = new google.maps.Geocoder();
	
	//set zipCode for radius of Circle
	var zipCode = '29733';
	
	//set the addresses for all markers
	var addresses = {};
	addresses[0] = {
		address: '882 Maplewood Ln. Rock Hill, SC 29730',
		dealerCode: '112897'
	};
	addresses[1] = {
		address: 'York, SC',
		dealerCode: '112897'
	};
	addresses[2] = {
		address: 'Fort Mill, SC',
		dealerCode: '111111'
	};
	

	
	if (geocoder) {
		geocoder.geocode({ 'address': zipCode }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				// IF GEOLOCATION API WORKS
				
				console.log(results[0].geometry.location);
				
				var radiusCenter = new google.maps.LatLng(results[0].geometry.location.A, results[0].geometry.location.F);
				
				var populationOptions = {
					strokeColor: '#0000FF',
					strokeOpacity: 0.7,
					strokeWeight: 1,
					fillColor: '#0000FF',
					fillOpacity: 0.15,
					map: map,
					center: radiusCenter,
					radius: 32186.9
				};
				// Add the circle for this city to the map.
				cityCircle = new google.maps.Circle(populationOptions);
			}
			else {
				console.log("Geocoding failed: " + status);
			}
		});
	}    
	for (var location in addresses) {
		if (geocoder) {
			geocoder.geocode({ 'address': addresses[location].address }, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					// IF GEOLOCATION API WORKS
					
					console.log(results[0].geometry.location);
					
					var addressLocation = new google.maps.LatLng(results[0].geometry.location.A, results[0].geometry.location.F);
					
					var marker = new google.maps.Marker({
						position: addressLocation,
						map: map,
						title: 'New Address'
					});
					
					var contentString = '<div class="infoWindow">'+
						'<div class="siteNotice">'+
						'</div>'+
						'<h1 class="firstHeading">Sample Chevrolet</h1>'+
						'<div class="infoContent">'+
						'<ul>'+
						'<li><b>Brand: </b>Chevrolet</li>'+
						'<li><b>Dealer Code: </b>'+ addresses[location].dealerCode +'</li>'+
						'<li><b><u>Address</u></b></li>'+
						'<li>2900 Government Blvd.<br/>Mobile, AL 36606</li>'+
						'</ul>'+
						'</div>'+
						'</div>';
				
					var infowindow = new google.maps.InfoWindow({
						content: contentString
					});
					
					google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(map,marker);
					});
					
				}
				else {
					console.log("Geocoding failed: " + status);
				}
			});
		} 
	}
	

	var dealerLocation = new google.maps.LatLng(34.885758, -81.0204865);
	var zipLatLng = new google.maps.LatLng(34.885758, -81.0204865);
	var mapOptions = {
		zoom: 9,
		center: zipLatLng
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),
	  mapOptions);
	  
	var marker = new google.maps.Marker({
		position: dealerLocation,
		map: map,
		title: 'Sample Chevrolet'
	});
	
	
	
}


google.maps.event.addDomListener(window, 'load', initialize);


/*
var Rm = 3961; // mean radius of the earth (miles) at 39 degrees from the equator
var Rk = 6373; // mean radius of the earth (km) at 39 degrees from the equator
	

function findDistance(frm) {
	var t1, n1, t2, n2, lat1, lon1, lat2, lon2, dlat, dlon, a, c, dm, dk, mi, km;
	
	// get values for lat1, lon1, lat2, and lon2
	t1 = frm.lat1.value;
	n1 = frm.lon1.value;
	t2 = frm.lat2.value;
	n2 = frm.lon2.value;
	
	// convert coordinates to radians
	lat1 = deg2rad(t1);
	lon1 = deg2rad(n1);
	lat2 = deg2rad(t2);
	lon2 = deg2rad(n2);
	
	// find the differences between the coordinates
	dlat = lat2 - lat1;
	dlon = lon2 - lon1;
	
	// here's the heavy lifting
	a  = Math.pow(Math.sin(dlat/2),2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(dlon/2),2);
	c  = 2 * Math.atan2(Math.sqrt(a),Math.sqrt(1-a)); // great circle distance in radians
	dm = c * Rm; // great circle distance in miles
	dk = c * Rk; // great circle distance in km
	
	// round the results down to the nearest 1/1000
	mi = round(dm);
	km = round(dk);
	
	// display the result
	frm.mi.value = mi;
	frm.km.value = km;
}


// convert degrees to radians
function deg2rad(deg) {
	rad = deg * Math.PI/180; // radians = degrees * pi/180
	return rad;
}


// round to the nearest 1/1000
function round(x) {
	return Math.round( x * 1000) / 1000;
}*/



    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>