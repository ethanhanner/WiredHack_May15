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
				$records[$index] = json_encode($row);
				$index += 1;
			}
		} else {
			echo "0 results";
		}
		
		echo htmlspecialchars("[");
		foreach($records as $curr) {
			echo htmlspecialchars($curr);
			echo htmlspecialchars(", ");
		}
		echo htmlspecialchars("]");

		
		$conn->close();
	?>
</div>
</body>
</html>