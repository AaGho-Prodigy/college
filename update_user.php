<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    // Update query
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "User updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating user: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
?>
