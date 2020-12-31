<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

 
if (isset($_POST['User_Id']) && isset($_POST['shop_id']) && isset($_POST['product_id'])) {
 
    // receiving the post params
    $User_Id = $_POST['User_Id'];
    //$Shop_Id = $_POST['Shop_Id'];
    $shop_id = $_POST['shop_id'];
    $product_id = $_POST['product_id'];
	
    // check if user is already existed with the same email
  
        // create a new user
        $cart = $db->storeProduct($User_Id,$shop_id,$product_id);
       
} 
?>