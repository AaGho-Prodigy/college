<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection file
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];

    // Update the order status to 'User_Confirmed'
    $stmt = $conn->prepare("UPDATE orders SET status = 'User_Confirmed', user_confirmed_at = NOW() WHERE id = ? AND user_id = ? AND status = 'Pending'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Order delivery confirmed.'); window.location.href = 'user_orders.php';</script>";
    } else {
        echo "<script>alert('Error: Order not found, already confirmed, or not in a pending state.'); window.location.href = 'user_orders.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = 'user_orders.php';</script>";
}
?>
