<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the order ID
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the order to Admin_Confirmed
    $sql = "UPDATE orders 
            SET admin_confirmed_at = NOW(), status = 'Admin_Confirmed' 
            WHERE id = ? AND status != 'Completed'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Order marked as delivered by Admin.'); window.location.href = 'admin.php#view-orders';</script>";
    } else {
        echo "<script>alert('Error: Order not found or already completed.'); window.location.href = 'admin.php#view-orders';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
