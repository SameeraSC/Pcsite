<?php
header('Content-Type: application/json');

// Include database connection class
require_once 'db_dps.class.php';

// Establish database connection
$conn = Db::connection();

// Query to get the highest registration number
$sql = "SELECT MAX(id) as maxRegNo FROM prayer";
$result = $conn->query($sql);

$response = array('maxRegNo' => null);
if ($result && $row = $result->fetch_assoc()) {
    $response['maxRegNo'] = $row['maxRegNo'];
}

echo json_encode($response);

// Close database connection
$conn->close();
?>
