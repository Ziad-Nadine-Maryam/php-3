<?php
 
/**
 * @author Ravi Tamada
 * @link https://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password, $phone_number, $address) {
        $unique_id = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, salt, phone_number, address, created_at) VALUES(?, ?, ?, ?, ?, ?, ? ,NOW())");
        $stmt->bind_param("sssssss", $unique_id, $name, $email, $encrypted_password, $salt, $phone_number, $address);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $users = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $users;
        } else {
            return false;
        }
    }
	 public function storeProduct($User_Id,$shop_name,$product_name) {
       
        $stmt = $this->conn->prepare("INSERT INTO favourites(User_Id,shop_id,product_id) VALUES(?, ?, ?);");
        $stmt->bind_param("sss", $User_Id,$shop_id,$product_id);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
       /* if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM cart WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $users = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $users;
        } else {
            return false;
        }*/
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $users = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $users['salt'];
            $encrypted_password = $users['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $users;
            }
        } else {
            return NULL;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
	public function isProductExisted($product_name) {
        $stmt = $this->conn->prepare("SELECT product_name from favourites WHERE email = ?");
 
        $stmt->bind_param("s",$product_name);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
	
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}
 
?>