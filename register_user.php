<?php
include('connect.php'); // Ensure this file initializes $conn correctly

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs and sanitize them
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmpassword']));

    // Validate input fields
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long.");
    }

    // Ensure $conn is initialized and valid
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Check if the username or email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        die("Error: The username or email is already registered.");
    }
    $checkStmt->close();

    // Insert user into the database with plain text password (no hashing)
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $password); // Store plain-text password

        if ($stmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            if ($conn->errno === 1062) { // Duplicate entry error
                echo "Error: This email is already registered.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "An unexpected error occurred: " . $e->getMessage();
    }

    $conn->close(); // Close the database connection afterwards
}
?>
