
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
		var dealerships;
		function getPHPdata() {
			var div = document.getElementById("dom-target");
			dealerships = div.textContent;
			dealerships = JSON.parse(dealerships);
			initialize();
		}

var map;
function initialize() {
	//Setup Google geocoder
	var geocoder = new google.maps.Geocoder();
	
	//set zipCode for radius of Circle
	var zipCode = '80121';
	var radius = 80467.2;
	
	//set the addresses for all markers
	var index;
	var addresses = {};
	var add;
	for(index = 0; index < dealerships.length; index++) {
		add = dealerships[index].Address1 + " ";
		add += dealerships[index].City + ", ";
		add += dealerships[index].State + " ";
		add += dealerships[index].PostalCode;
		addresses[index] = {
			address: add,
			dealerCode: dealerships[index].DealerCode,
			dealerName: dealerships[index].DealerName
		};
	}


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
	console.log(dealerships.length);
	var x;
	for (x = 0; x < dealerships.length; x++) {
		if (geocoder) {
			console.log("1: " + x);
			geocoder.geocode({ 'address': addresses[x].address }, function (results, status) {
				console.log("2: " + x);
				if (status == google.maps.GeocoderStatus.OK) {
					// IF GEOLOCATION API WORKS
					tempfrm.lat2 = results[0].geometry.location.A;
					tempfrm.lon2 = results[0].geometry.location.F;
					tempfrm.mi = distance(tempfrm.lat1,tempfrm.lon1,tempfrm.lat2,tempfrm.lon2);
					tempfrm.meters = 1609.34 * tempfrm.mi;
					if(tempfrm.meters <= radius) {
						var addressLocation = new google.maps.LatLng(results[0].geometry.location.A, results[0].geometry.location.F);
						console.log(x);
						var marker = new google.maps.Marker({
							position: addressLocation,
							map: map,
							title: addresses[x].dealerName
						});
						var contentString = '<div id="infoWindow'+x+'" class="infoWindow">'+
							'<div class="siteNotice">'+
							'</div>'+
							'<h1 class="firstHeading">' + dealerships[x].DealerName + '</h1>'+
							'<div class="infoContent">'+
							'<ul>'+
							'<li><b>Brand: </b>Chevrolet</li>'+
							'<li><b>Dealer Code: </b>'+ addresses[x].dealerCode +'</li>'+
							'<li><b><u>Address</u></b></li>'+
							'<li>2900 Government Blvd.<br/>Mobile, AL 36606</li>'+
							'</ul>'+
							'</div>'+
							'</div>';
						console.log(contentString);
				
						var infowindow = new google.maps.InfoWindow({
							content: contentString
						});
					
						google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(map,marker);
						});
					}
				}
				else {
					console.log("Geocoding failed: " + status);
				}
			});
		} 
	}
}


google.maps.event.addDomListener(window, 'load', getPHPdata);

function distance(lat1, lon1, lat2, lon2) {
    var radlat1 = Math.PI * lat1/180
    var radlat2 = Math.PI * lat2/180
    var radlon1 = Math.PI * lon1/180
    var radlon2 = Math.PI * lon2/180
    var theta = lon1-lon2
    var radtheta = Math.PI * theta/180
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist)
    dist = dist * 180/Math.PI
    dist = dist * 60 * 1.1515
    return dist
}

    </script>
  </head>
<body>
    <div id="map-canvas"></div>
	<div id="dom-target" style="display:none;">
	<?php
		$servername = "localhost";
		$username = "root";
		$password = "vmo55";
		
		$conn = new mysqli($servername, $username, $password);
		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "use Insignia;";
		if($conn->query($sql) === FALSE) {
			echo "Error selecting database: " . $conn->error;
			echo "<br/>";
			echo "\n";
		}
		
		$sql = "SELECT * FROM Dealership;";
		$result = $conn->query($sql);
		$index = 0;
		$records = array();
		if ($result->num_rows > 0) {
			foreach($result as $row) {
				$row["DealerName"] = str_replace(",", " ", $row["DealerName"]);
				$row["Address1"] = str_replace(",", " ", $row["Address1"]);
				$records[$index] = json_encode($row);
				$index += 1;
			}
		} else {
			echo "0 results";
		}
		
		$numRecords = sizeof($records);
		$count = 0;
		echo htmlspecialchars("[");
		foreach($records as $curr) {
			$count += 1;
			echo htmlspecialchars($curr);
			if($count != $numRecords) {
				echo htmlspecialchars(", ");
			}
		}
		echo htmlspecialchars("]");

		
		$conn->close();
	?>
	</div>
</body>
</html>