<?php

// Check if the request is coming from an AJAX call
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $inputData = json_decode(file_get_contents('php://input'), true);
    
    // Validate input data
    if (isset($inputData['subDeanComment']) && isset($inputData['studentId'])) {
        $subDeanComment = $inputData['subDeanComment'];
        $matricNo = $inputData['studentId']; // studentId is actually the matricNo

        // Database connection using mysqli
        $servername = "localhost";  // Your database server
        $username = "root";         // Your database username
        $password = "";             // Your database password
        $dbname = "pg forms";       // Your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Start a transaction to ensure both queries are executed atomically
        $conn->begin_transaction();

        try {
            // Prepare the SQL query to update HOD comment
            $updateSql = "UPDATE students SET sub_dean_comment = ? WHERE matricNo = ?";

            // Prepare statement for updating HOD comment
            if ($stmt = $conn->prepare($updateSql)) {
                // Bind parameters to the SQL query
                $stmt->bind_param("ss", $subDeanComment, $matricNo); // Bind matricNo as a string

                // Execute the query
                if (!$stmt->execute()) {
                    throw new Exception('Failed to update sub dean comment.');
                } 

                // Close the statement
                $stmt->close();
            } else {
                throw new Exception('Failed to prepare the SQL query for sub dean comment.');
            }

            // Insert matricNo into the endorsements table
            $endorseSql = "INSERT INTO sub_dean_endorsements (matricNo) VALUES (?)";
            if ($stmt = $conn->prepare($endorseSql)) {
                // Bind the matricNo parameter to the query
                $stmt->bind_param("s", $matricNo);  // MatricNo is a string

                // Execute the insertion
                if (!$stmt->execute()) {
                    throw new Exception('Failed to insert into endorsements.');
                }

                // Close the statement
                $stmt->close();
            } else {
                throw new Exception('Failed to prepare SQL query for endorsements.');
            }

            // Commit the transaction if everything was successful
            $conn->commit();

            // Send success response
            echo json_encode(['success' => true, 'message' => 'Update and endorsement successful!']);

        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        // Close the connection
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
}

?>
