<?php
   define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "android_api");
 
 $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   // mysql_select_db($dbname, $conn);
    $User_Id = $_POST['User_Id'];
	$shop_id = $_POST['shop_id'];
	$product_id = $_POST['product_id'];

    //$result = mysql_query("DELETE FROM cart WHERE Shop_Id=$Shop_Id" AND User_Id=$User_Id, $conn);
$Sql_Query = "DELETE FROM saveditems WHERE User_Id=$User_Id AND shop_id=$shop_id AND product_id=$product_id";
 
 if(mysqli_query($conn,$Sql_Query)){
 
 echo 'Data Deleted Successfully';
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($conn);
   
?> 