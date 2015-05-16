<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

$state = $_GET['state'];

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

$sql = "SELECT * FROM Dealership WHERE state = '" . $state . "';";
$result = $conn->query($sql);

$conn->close();

$index = 0;
$records = array();
if ($result->num_rows > 0) {
	foreach($result as $row) {
		$records[$index] = $row;
		$index += 1;
	}
} else {
	echo "0 results";
}

echo json_encode($records);


