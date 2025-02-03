<?php
/**
 * Register a new user in the system.
 * 
 * @param string $_POST['name'] The name of the new user.
 * @param string $_POST['email'] The email address of the new user.
 * @param string $_POST['password'] The password of the new user.
 * 
 * @return JSON Response indicating success or failure.
 */

// 1. Include the database connection
require_once '../db.php';
$conn = connectDB(); // or use connectPDO() if preferred

//code starts here

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Check validate    

 function chkvalid($name, $email, $password) {
    $error = false;
    $err_msg = null;

    if(empty($name)) {
        $err_msg = "Name is empty";
        $error = true;
    }
       
    if(empty($email)) {
        $err_msg = "Email is empty";
        $error = true;
    }
    if(empty($password)) {
        $err_msg = "Password is empty";
        $error = true;
    } 
    $errorInfo = [
        "error" => $error,
        "err_msg" => $err_msg
    ];
    return $errorInfo;
}

// POST Values
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$validate = chkvalid($name, $email, $password);
$success = false;

if (!$validate['error']){
    $status = 200;
    $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    $msg = "You are registered successfully";

}else {
    $status = 401;
    $msg = $validate['err_msg'];
  }

  $data = [
    'status' => $status,
    'msg' => $msg
 ];

  echo json_encode($data);
?>
