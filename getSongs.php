<?php
/**
 * Fetch all songs from the database.
 * 
 * @return JSON Response with all the available songs or an error message.
 */

// 1. Include the database connection
require_once '../db.php';
$conn = connectDB(); // or use connectPDO() if preferred

//code starts here

// fetch records from database by using select query
$result = $conn->query("SELECT * FROM songs");
$arr_songs = [];
while ($row = $result->fetch_assoc()) {
    $arr_songs[] = $row;
}

echo json_encode($arr_songs);

?>
