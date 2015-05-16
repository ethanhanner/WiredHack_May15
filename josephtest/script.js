$(document).ready(function() {
	var tempfrm = {
		lat1 : '0',
		lat2 : '0',
		lon1 : '0',
		lon2 : '0',
		mi: '0',
		meters: '0'
		
	 };
	 
	var radius = 80467.2;
	$.ajax({
		type:"GET",
		url: "data.php",
		data: {
			state: 'CO'	
		},
		dataType: 'json',
		success : function(data){
			for(var i = 0; i<data.length; i++){
				
				//Setup Google geocoder
				var geocoder = new google.maps.Geocoder();
				//Setup address string
				var address = data[i].Address1 + " " + data[i].City + ", " + data[i].State + " " + data[i].PostalCode;
				console.log(data[i]);
				
				var contentString = '<div class="infoWindow">'+
								'<div class="siteNotice">'+
								'</div>'+
								'<h1 class="firstHeading">' + data[i].DealerName + '</h1>'+
								'<div class="infoContent">'+
								'<ul>'+
								'<li><b>Brand: </b>Chevrolet</li>'+
								'<li><b>Dealer Code: </b>'+ '' +'</li>'+
								'<li><b><u>Address</u></b></li>'+
								'<li>2900 Government Blvd.<br/>Mobile, AL 36606</li>'+
								'</ul>'+
								'</div>'+
								'</div>';
				infowindow = new google.maps.InfoWindow();
				
				if (geocoder) {
					geocoder.geocode({ 'address': address }, function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							tempfrm.lat2 = results[0].geometry.location.A;
							tempfrm.lon2 = results[0].geometry.location.F;
							tempfrm.mi = distance(tempfrm.lat1,tempfrm.lon1,tempfrm.lat2,tempfrm.lon2);
							console.log(tempfrm.mi);
							tempfrm.meters = 1609.34 * tempfrm.mi;
								var addressLocation = new google.maps.LatLng(tempfrm.lat2, tempfrm.lon2);
								var marker = new google.maps.Marker({
									position: addressLocation,
									map: map,
									title: 'something'
								});
							google.maps.event.addListener(marker, 'click', function() {
								infowindow.setContent(contentString);
								infowindow.open(map,marker);
							});
	
						}
						else {
							console.log("Geocoding failed: " + status);
						}
					});
				}
				
			}	
		}
	});
	$.ajax({
		type:"GET",
		url: "data.php",
		dataType: 'json',
		data: {
			state: 'CO'	
		},
		success : function(data){
			for(var i = 0; i<=data.length;i++){
				var address = data[i].Address1 + " " + data[i].City + ", " + data[i].State + " " + data[i].PostalCode;
				$('#results').append('<div class="dealerBlock"><h1>' + data[i].DealerName + '</h1>' + '<p><b>Brand: </b>' + data[i].BrandName + '</p> <p>' + address + '</p></div>');
			}
		}
	});
	
});
var map;
function generateMap(){
	//Setup Google geocoder
	var geocoder = new google.maps.Geocoder();
	
	//set zipCode for radius of Circle
	var zipCode = '80121';
	var radius = 80467.2;
	

	var tempfrm = {
		lat1 : '0',
		lat2 : '0',
		lon1 : '0',
		lon2 : '0',
		mi: '0',
		meters: '0'
		
	 };
	
	if (geocoder) {
		geocoder.geocode({ 'address': zipCode }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				// IF GEOLOCATION API WORKS
				tempfrm.lat1 = results[0].geometry.location.A;
				tempfrm.lon1 = results[0].geometry.location.F;
				var zipLatLng = new google.maps.LatLng(tempfrm.lat1, tempfrm.lon1);
				var mapOptions = {
					zoom: 7,
					center: zipLatLng
				};
				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				var radiusCenter = new google.maps.LatLng(results[0].geometry.location.A, results[0].geometry.location.F);
				
				var circleOptions = {
					strokeColor: '#0000FF',
					strokeOpacity: 0.7,
					strokeWeight: 1,
					fillColor: '#0000FF',
					fillOpacity: 0.15,
					map: map,
					center: radiusCenter,
					radius: radius
				};
				// Add the circle for this city to the map.
				cityCircle = new google.maps.Circle(circleOptions);
				
				
			}
			else {
				console.log("Geocoding failed: " + status);
			}
		});
	}  

}
function createMarkers(tempfrm, address, radius) {
	if(tempfrm.meters <= radius) {
		var addressLocation = new google.maps.LatLng(tempfrm.lat2, tempfrm.lon2);
		var marker = new google.maps.Marker({
			position: addressLocation,
			map: map,
			title: 'Something'
		});
	}
	var contentString = '<div class="infoWindow">'+
		'<div class="siteNotice">'+
		'</div>'+
		'<h1 class="firstHeading">' + address.dealerName + '</h1>'+
		'<div class="infoContent">'+
		'<ul>'+
		'<li><b>Brand: </b>Chevrolet</li>'+
		'<li><b>Dealer Code: </b>'+ '' +'</li>'+
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
function distance(lat1, lon1, lat2, lon2) {
    var radlat1 = Math.PI * lat1/180;
    var radlat2 = Math.PI * lat2/180;
    var radlon1 = Math.PI * lon1/180;
    var radlon2 = Math.PI * lon2/180;
    var theta = lon1-lon2;
    var radtheta = Math.PI * theta/180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist);
    dist = dist * 180/Math.PI;
    dist = dist * 60 * 1.1515;
    return dist;
}
google.maps.event.addDomListener(window, 'load', generateMap);

