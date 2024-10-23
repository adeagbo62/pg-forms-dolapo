<?php
// Database connection
$host = 'localhost';
$dbname = 'pg forms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the selected student ID from the AJAX request
    $studentId = $_GET['studentId'];
    // SQL query to fetch student details by ID
    $stmt = $pdo->prepare("SELECT * FROM students WHERE matricNo = :studentId");
    $stmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch student information
    $studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the student information as a JSON object
    echo json_encode($studentInfo);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
