<?php
session_start();
include('connect.php');

if (isset($_POST['register'])) {
    // Registration logic
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirmpassword'];

    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords don't match!";
        header("Location: login.php?register=1");
        exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error'] = "Username already exists!";
        header("Location: login.php?register=1");
        exit();
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Registration failed!";
        header("Location: login.php?register=1");
    }
    exit();
}

if (isset($_POST['login'])) {
    // Login logic
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            
            header("Location: " . ($user['role'] === 'admin' ? 'admin.php' : 'index.php'));
            exit();
        }
    }
    
    $_SESSION['error'] = "Invalid credentials!";
    header("Location: login.php");
    exit();
}