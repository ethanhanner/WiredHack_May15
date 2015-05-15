<html>
<head>
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
		
		$count = 0;
		$fp = fopen("dealershipsCSV.csv", "r");
		while(!feof($fp)) {
			$fields = fgetcsv($fp);
			$sql = "INSERT INTO Dealership (BrandName, DealerName, SignedOn, DealerCode, Address1, City, State, PostalCode) VALUES ('" . $fields[0] . "', '" . $fields[1] . "', '" . $fields[2] . "', " . $fields[3] . ", '" . $fields[5] . "', '" . $fields[7] . "', '" . $fields[8] . "', " . $fields[9] . ");";
			//echo($sql);
			//echo("<br/>");
			//echo("\n");
			if($conn->query($sql) === FALSE) {
				echo "Error Inserting: " . $conn->error;
				echo "<br/>";
				echo "\n";
			} else {
				$count += 1;
			}
		}
		
		echo("Number of Dealerships Inserted = " . $count);
		
		$conn->close();
	?>
</head>

<body>

</body>
</html>