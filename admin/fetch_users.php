<?php
// Database connection configuration
$host = "localhost"; // Your database host
$username = "root"; // Your database username
$password = ""; // No password
$database = "registration"; // Your database name

// Enable CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Establish a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch users
$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);

// Prepare data for output
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($users);

// Close the connection
$conn->close();
?>
