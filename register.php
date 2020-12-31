<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

 
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phone_number']) && isset($_POST['address'])) {
 
    // receiving the post params
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
	$address = $_POST['address'];
    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $email, $password,$phone_number ,$address);
        if ($users) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["unique_id"] = $user["unique_id"];
            $response["users"]["name"] = $user["name"];
            $response["users"]["email"] = $user["email"];
			$response["users"]["phone_number"] = $user["phone_number"];
            $response["users"]["address"] = $user["address"];
            $response["users"]["created_at"] = $user["created_at"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!" ;
    echo json_encode($response);
}
?>