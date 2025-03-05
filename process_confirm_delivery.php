<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];

// Update both status AND is_confirmed
$sql = "UPDATE orders 
        SET status = 'delivered', 
            is_confirmed = 1,          // Add this line
            user_confirmed_at = NOW() 
        WHERE id = ? AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $order_id, $user_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: confirm_delivery.php?success=1");
} else {
    header("Location: confirm_delivery.php?error=" . urlencode(mysqli_error($conn)));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();
?>