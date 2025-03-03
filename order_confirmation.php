<?php
// Ensure that the user is logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the order ID from the form submission
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id']; // Get user ID from session

    // Update the user confirmation
    $sql = "UPDATE orders 
            SET user_confirmed_at = NOW(), status = 'User_Confirmed' 
            WHERE id = ? AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);

    if ($stmt->execute()) {
        header("Location: my_orders.php"); // Redirect to user's orders page after confirmation
        exit();
    } else {
        echo "Error confirming order: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
