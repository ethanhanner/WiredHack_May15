<!DOCTYPE html>
<html>
<head>
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
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSVrjbuwyymqZLKDxb5aU4-MSzkEpjMSc"></script>
	<script type="text/javascript">
		var geocoder = new google.maps.Geocoder();
		var map, cityCircle;
		var zipLat, zipLng;
		var dealerships;
		var zipCode = '80121';
		var radius = 80467.2;
	
		function initialize() {
			var div = document.getElementById("dom-target");
			dealerships = div.textContent;
			dealerships = JSON.parse(dealerships);
			
			// display a map centered on the zipCode with a circle radius
			geocoder.geocode({'address': zipCode}, function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					zipLat = results[0].geometry.location.A;
					zipLng = results[0].geometry.location.F;
					zipLatLng = new google.maps.LatLng(zipLat, zipLng);
					var mapOptions = {
						zoom: 7,
						center: zipLatLng
					};
					map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
					var circleOptions = {
						strokeColor: '#0000FF',
						strokeOpacity: 0.7,
						strokeWeight: 1,
						fillColor: '#0000FF',
						fillOpacity: 0.15,
						map: map,
						center: zipLatLng,
						radius: radius
					};
					cityCircle = new google.maps.Circle(circleOptions);
				} else {
					console.log("Geocoding failed: " + status);
				}
			});
			
			for(var x = 0; x < dealerships.length; x++) {
				setTimeout(testAddress(x), 6000);
			}
		}
		
		function testAddress(x) {
			var address, addressLat, addressLng;
			address = dealerships[x].Address1 + " ";
			address += dealerships[x].City + ", ";
			address += dealerships[x].State + " ";
			address += dealerships[x].PostalCode;
			geocoder.geocode({'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					addressLat = results[0].geometry.location.A;
					addressLng = results[0].geometry.location.F;
					var miles = distance(zipLat, zipLng, addressLat, addressLng);
					var meters = 1609.34 * miles;
					if(meters <= radius) {
						console.log(address);
					}
				} else {
					console.log("Geocoding failed: " + status);
				}
			});
		}
		
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
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>

<body>
	<div id="map-canvas"></div>
	<!-- hidden div holding all the customer records from the database -->
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