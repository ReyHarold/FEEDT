<?php
header('Content-Type: application/json');
include "../../conn.php";

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Retrieve query
$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchFor="";
// Use prepared statements to prevent SQL injection
if(trim($query) === ''){
$sql = "SELECT user.email,user.name, user_pic, log.description, log.date FROM log LEFT JOIN user ON log.userid = user.userid ORDER BY log.date DESC;";
}else{
$sql = "SELECT user.email, user.name, user_pic, log.description, log.date 
        FROM log 
        LEFT JOIN user ON log.userid = user.userid 
        WHERE user.name LIKE ? OR log.description LIKE ? OR log.date LIKE ? 
        ORDER BY log.date DESC";
};
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
if(trim($query) === ''){

}else{
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}
$stmt->execute();
$result = $stmt->get_result();

$results = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure image is base64 encoded correctly
        $row['user_pic'] = base64_encode($row['user_pic']);
        $results[] = $row;
    }
}

echo json_encode($results);
$conn->close();
?>
