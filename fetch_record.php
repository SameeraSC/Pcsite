<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db_dps.class.php'; // Adjust path if needed

// Set content type for JSON response
header('Content-Type: application/json');

// Ensure request method is POST and regNo is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $regNo = intval($_POST['id']);
    
    // Validate regNo
    if ($regNo <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid record number']);
        exit;
    }

    // Database connection
    $conn = Db::connection();

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM prayer WHERE id = ?");
    $stmt->bind_param("i", $regNo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Return the HTML content for the record details
        $recordDetails = '
            <div class="card compact-card">
                <div class="card-header">Record Details</div>
                <div class="card-body">
                    <p><strong>Name:</strong> ' . htmlspecialchars($row["name"]) . '</p>
                    <p><strong>ID:</strong> ' . htmlspecialchars($row["id"]) . '</p>
                    <p><strong>Gender:</strong> ' . htmlspecialchars($row["gender"]) . '</p>
                    <p><strong>Age:</strong> ' . htmlspecialchars($row["age"]) . '</p>
                    <p><strong>Religion:</strong> ' . htmlspecialchars($row["religion"]) . '</p>
                    <p><strong>Province:</strong> ' . htmlspecialchars($row["tel3"]) . '</p> <!-- Adjust as needed -->
                    <p><strong>District:</strong> ' . htmlspecialchars($row["tel2"]) . '</p> <!-- Adjust as needed -->
                    <p><strong>Date:</strong> ' . date("d-M-y", strtotime($row["ts"])) . '</p>
                </div>
            </div>';

        // Output the HTML wrapped in a JSON response
        echo json_encode(['status' => 'success', 'html' => $recordDetails]);
    } else {
        // No record found
        echo json_encode(['status' => 'error', 'message' => 'No record found']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>

