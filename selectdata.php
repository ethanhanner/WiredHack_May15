<html>
<head>
<script>
	function initialize() {
		var div = document.getElementById("dom-target");
		var myData = div.textContent;
		var resultsP = document.getElementById("results");
		resultsP.innerHTML = myData;
	}
</script>
</head>
<body onload=initialize()>
<p id="results"></p>


<div id="dom-target" style="display:none;">
	<?php
		$servername = "192.168.1.82";
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
		
		$sql = "SELECT * FROM Dealership WHERE State = 'FL';";
		$result = $conn->query($sql);
		$index = 0;
		$records = array();
		if ($result->num_rows > 0) {
			foreach($result as $row) {
				$row["DealerName"] = str_replace(",", " ", $row["DealerName"]);
				$row["Address1"] = str_replace(",", " ", $row["Address1"]);
				$records[$index] = json_encode($row);
				echo ("records[" . $index . "] = " . $records[$index]);
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