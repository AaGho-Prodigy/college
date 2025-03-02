<?php
session_start();
require 'connect.php'; // Ensure you have a file to connect to the database

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

// Ensure the order_id is passed in the URL
if (!isset($_GET['order_id'])) {
    die("Error: Order ID is missing.");
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id']; // Get the order ID from the URL

// Fetch order details from the database
$orderQuery = "SELECT o.total_price, o.status, o.payment_status, oi.product_id, oi.quantity, p.title, p.price
               FROM orders o
               JOIN order_items oi ON o.id = oi.order_id
               JOIN products p ON oi.product_id = p.id
               WHERE o.id = ? AND o.user_id = ?";

$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch order data
$order = $result->fetch_all(MYSQLI_ASSOC);

if (!$order) {
    die("Error: Order not found.");
}

$stmt->close();

// Handle user confirmation (Confirm Received)
if (isset($_POST['confirm_received'])) {
    $updateQuery = "UPDATE orders SET status = 'Delivered' WHERE id = ? AND user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $order_id, $user_id);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Order status updated to 'Delivered'.";
    } else {
        echo "Error: Failed to update order status.";
    }

    $updateStmt->close();

    // Redirect to the confirmation page after updating
    header("Location: order_confirmation.php?order_id=" . $order_id);
    exit();
}

// Handle admin confirmation (Confirm Payment Received)
if (isset($_POST['confirm_payment'])) {
    // Admin must be logged in with admin role for this to work
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $updatePaymentQuery = "UPDATE orders SET payment_status = 'Completed' WHERE id = ?";
        $paymentStmt = $conn->prepare($updatePaymentQuery);
        $paymentStmt->bind_param("i", $order_id);
        $paymentStmt->execute();

        if ($paymentStmt->affected_rows > 0) {
            echo "Payment status updated to 'Completed'.";
        } else {
            echo "Error: Failed to update payment status.";
        }

        $paymentStmt->close();

        // Redirect to the confirmation page after updating
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        die("Error: Only admin can confirm payment.");
    }
}

// Check if both the order status is delivered and the payment is completed
$checkSuccessQuery = "SELECT status, payment_status FROM orders WHERE id = ? AND user_id = ?";
$checkStmt = $conn->prepare($checkSuccessQuery);
$checkStmt->bind_param("ii", $order_id, $user_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$orderStatus = $checkResult->fetch_assoc();

$checkStmt->close();

// If both status are 'Delivered' and 'Completed', mark the order as 'Successful'
if ($orderStatus['status'] === 'Delivered' && $orderStatus['payment_status'] === 'Completed') {
    $updateSuccessQuery = "UPDATE orders SET order_status = 'Successful' WHERE id = ? AND user_id = ?";
    $updateSuccessStmt = $conn->prepare($updateSuccessQuery);
    $updateSuccessStmt->bind_param("ii", $order_id, $user_id);
    $updateSuccessStmt->execute();

    if ($updateSuccessStmt->affected_rows > 0) {
        echo "Order marked as 'Successful'.";
    } else {
        echo "Error: Failed to update order to 'Successful'.";
    }

    $updateSuccessStmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order! Below are your order details:</p>

    <h2>Order ID: <?php echo htmlspecialchars($order_id); ?></h2>
    <h3>Status: <?php echo htmlspecialchars($order[0]['status']); ?></h3>
    <h3>Payment Status: <?php echo htmlspecialchars($order[0]['payment_status']); ?></h3>

    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_price = 0;
            foreach ($order as $item) {
                $item_total = $item['price'] * $item['quantity'];
                $total_price += $item_total;
                echo '<tr>';
                echo '<td>' . htmlspecialchars($item['title']) . '</td>';
                echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                echo '<td>$' . number_format($item['price'], 2) . '</td>';
                echo '<td>$' . number_format($item_total, 2) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <h3>Total Price: $<?php echo number_format($total_price, 2); ?></h3>

    <p>Your order will be processed shortly. You will receive an email confirmation soon.</p>

    <!-- User Confirmation Button (Confirm Received) -->
    <?php if ($order[0]['status'] !== 'Delivered') { ?>
        <form method="POST">
            <button type="submit" name="confirm_received">Confirm Received</button>
        </form>
    <?php } else { ?>
        <p>Your order has already been confirmed as received.</p>
    <?php } ?>

    <!-- Admin Confirmation Button (Confirm Payment Received) -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $order[0]['payment_status'] !== 'Completed') { ?>
        <form method="POST">
            <button type="submit" name="confirm_payment">Confirm Payment Received</button>
        </form>
    <?php } elseif ($order[0]['payment_status'] === 'Completed') { ?>
        <p>Payment has already been confirmed.</p>
    <?php } ?>

    <a href="index.php">Return to Shop</a>
</body>
</html>
