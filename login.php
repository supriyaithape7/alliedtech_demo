<?php
/**
 * Logs in a user based on the provided email and password.
 * 
 * @param string $_POST['email'] The email of the user.
 * @param string $_POST['password'] The password of the user.
 * 
 * @return JSON Response indicating success or failure.
 */

// 1. Include the database connection
require_once '../db.php';
$conn = connectDB(); // or use connectPDO() if preferred

//code starts here


// Check validate    
function chkvalid($email, $password) {
    $error = false;
    $err_msg = null;

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
$email = $_POST['email'];
$password = $_POST['password'];

$validate = chkvalid($email, $password);

if (!$validate['error']){

        $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password = '$password'");
        $rows= $result->fetch_assoc();

        if ($result->num_rows > 0) {

            $status = 200;
            $msg = "Logged in successfully";
            $data = $rows;
            $data = [
                'status' => 200,
                'msg' => "Logged in successfully",
                'data' => $rows
            ];
        }else{
            $data = [
                'status' => 404,
                'msg' => "Invalid User",
                'data' => []
            ];

        }       
   

}else {
    $data = [
        'status' => 401,
        'msg' => $validate['err_msg'],
        'data' => []
    ];
  }

   echo json_encode($data);
?>

