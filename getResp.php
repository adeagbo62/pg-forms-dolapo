<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$dbname = 'pg forms';
$username = 'root'; // Default username for XAMPP
$password = ''; // Empty password for XAMPP

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if there is a search term
    $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

    // If no search term is provided, fetch all students
    if (!empty($searchTerm)) {
        $stmt = $pdo->prepare("SELECT id, studentName FROM students WHERE studentName LIKE :searchTerm LIMIT 28");
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    } else {
        // Fetch all students if no search term is provided
        $stmt = $pdo->prepare("SELECT id, studentName FROM students LIMIT 28");
    }

    $stmt->execute();

    // Fetch results as an associative array
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare response data in the format Select2 expects
    $response = [];
    foreach ($students as $student) { 
        $response[] = [
            'id' => $student['id'],  // The value sent when a user selects an option
            'text' => $student['studentName']  // The label displayed in the dropdown
        ];
    }

    // Return the response as JSON
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
}
