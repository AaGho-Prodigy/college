<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    die("Unauthorized access.");
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE orders SET status = 'delivered', user_confirmed_at = NOW() 
        WHERE id = '$order_id' AND user_id = '$user_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: confirm_delivery.php?success=1");
    exit();
} else {
    header("Location: confirm_delivery.php?error=1");
    exit();
}

mysqli_close($conn);
?>
