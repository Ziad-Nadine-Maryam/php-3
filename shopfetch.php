<?php
 
/**
 * Database config variables
 */
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "android_api");
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
//checking if any error occured while connecting
if(mysqli_connect_error()){
	echo"Failed to connect to MYSQL: ".mysqli_connect_error();
	die();
	
}
$sql = "SELECT * FROM shop_products";

$result = $conn->query($sql);

$response = array();
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	  $tem = $row;
	  array_push($response,$tem);
	  //$json = json_encode($tem);
	  //echo $json;
    
  }
 
   $json = json_encode($response);
	  echo $json;/////////////
} else {
  echo "0 results";
}

$conn->close();
?>
