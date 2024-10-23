<?php

// Check if the request is coming from an AJAX call
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $inputData = json_decode(file_get_contents('php://input'), true);
    
    // Validate input data
    if (isset($inputData['hodComment']) && isset($inputData['studentId'])) {
        $hodComment = $inputData['hodComment'];
        $studentId = $inputData['studentId'];

        // Database connection using mysqli
        $servername = "localhost";  // Your database server
        $username = "root";         // Your database username
        $password = "";             // Your database password
        $dbname = "pg forms";  // Your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query using a prepared statement
        $sql = "UPDATE students SET hod_comment = ? WHERE id = ?";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters to the SQL query
            $stmt->bind_param("si", $hodComment, $studentId);

            // Execute the query
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Update successful!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed.']);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
        }

        // Close the connection
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
}
?>
