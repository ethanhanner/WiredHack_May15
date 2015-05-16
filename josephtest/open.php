<?php
$zipcode = 82715;
$radius = 25;
$lat1 = 0;
$lon1 = 0;
$zip2 = 0;
$lat2 = 0;
$lon2 = 0;
$distance = 0;
$handle = fopen("USzip.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $teile = explode(" ",$line);;
		//echo $teile[1];
		if (intval($teile[0]) === $zipcode)
		{ $lat1 = $teile[1];
          $lon1 = $teile[2];
    	 }
    }
echo $lat1;
    fclose($handle);

	
} else {
    // error opening the file.
} 

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
				$zip2 = $row["PostalCode"]; 
			     echo $zip2."     ";
				 $distance = getdistance($zip2,$lon1,$lat1);
				 if($distance <= $radius)
				 {
					// echo  $result."    ||||||||||         ";
				 }
			}
		} else {
			echo "0 results";
		}
		
function getdistance($zip2,$lon1,$lat1){
	$lon2 = 0;
	$lat2 = 0;
	
$handle4 = fopen("USzip1.txt", "r");
if ($handle4) {
    while (!feof($handle4)) {
		$line1 = fgets($handle4);
       //$teile = explode(" ", $line1);
	//if (  $line1[0] === $zip2 )
		//{ $lat2 = $line1[1];
        //$lon2 = $line1[2];
    	 //}
	}
    fclose($handle4);
} else {
    // error opening the file.
} 
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  echo $miles;
  return $miles;
  
}
?>