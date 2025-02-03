<?php
/**
 * Fetch songs based on the given category.
 * 
 * @param string The category id to filter the songs.
 * 
 * @return JSON Response with the filtered songs or an error message.
 */

// 1. Include the database connection
require_once '../db.php';
$conn = connectDB(); // or use connectPDO() if preferred

//code starts here

// fetch records from database by using select query

$category_id = $_GET['category_id'];

$result = $conn->query("SELECT s.*, c.status FROM songs s
LEFT JOIN categories c ON c.id = s.category_id
WHERE s.category_id ='$category_id' AND c.status='active'");

$arr_songs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arr_songs[] = $row;
    }

       echo json_encode($arr_songs);
}else{
    echo json_encode(["message" => "Record not found"]);
}

?>
