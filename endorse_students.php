<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "pg_forms");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $matricNo = $data['matricNo'];

    // Insert the matricNo into endorsed_students table
    $sql = "INSERT INTO endorsed_students (matricNo) VALUES ('$matricNo')";
    
    if (mysqli_query($conn, $sql)) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
