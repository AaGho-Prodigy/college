<?php
// Ensure that only admins can access this page
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the order ID from the form submission
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the admin confirmation
    $sql = "UPDATE orders 
            SET admin_confirmed_at = NOW(), status = 'Admin_Confirmed' 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: admin.php#view-orders");
        exit();
    } else {
        echo "Error confirming delivery: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
