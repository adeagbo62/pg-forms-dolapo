<?php
$host = 'localhost';
$dbname = 'pg forms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Prepare the SQL statement to insert data into the 'formn' table
    $stmt = $pdo->prepare("UPDATE students SET deptPgComment = :comment where id = :id");
    
    // Bind form data to the SQL query
    $stmt->bindParam(':comment', $_POST['comment']);
    $stmt->bindParam(':id', $_POST['id']);

    // Execute the query
    $stmt->execute();

    // Send success response
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Handle any errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
