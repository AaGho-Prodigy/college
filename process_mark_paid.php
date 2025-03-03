<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_POST['order_id'])) {
    die("Invalid request.");
}

$order_id = $_POST['order_id'];

$sql = "UPDATE orders SET payment_status = 'paid', admin_confirmed_at = NOW() 
        WHERE id = '$order_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: admin_orders.php?success=1");
    exit();
} else {
    header("Location: admin_orders.php?error=1");
    exit();
}

mysqli_close($conn);
?>
