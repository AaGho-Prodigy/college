<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure the order_id is passed in the URL and sanitize the input
if (!isset($_GET['order_id'])) {
    die("Order ID not provided.");
}

$order_id = (int)$_GET['order_id']; // Casting to integer for safety

// Fetch order details
$order_query = "SELECT o.total_price, o.status, o.payment_status, o.created_at, u.username 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = ?";
$stmt = mysqli_prepare($conn, $order_query);
mysqli_stmt_bind_param($stmt, 'i', $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Failed to execute order query: " . mysqli_error($conn));
}

$order = mysqli_fetch_assoc($result);
if (!$order) {
    die("Order not found.");
}

// Fetch order items
$order_items_query = "SELECT oi.quantity, oi.product_id, p.title AS product_name, p.price 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.id 
                      WHERE oi.order_id = ?";
$stmt_items = mysqli_prepare($conn, $order_items_query);
mysqli_stmt_bind_param($stmt_items, 'i', $order_id);
mysqli_stmt_execute($stmt_items);
$result_items = mysqli_stmt_get_result($stmt_items);

if (!$result_items) {
    die("Failed to execute order items query: " . mysqli_error($conn));
}

// Handle delivery confirmation
if (isset($_POST['confirm_delivery'])) {
    // Update order status to 'delivered'
    $update_query = "UPDATE orders SET status = 'delivered' WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, 'i', $order_id);
    if (mysqli_stmt_execute($stmt_update)) {
        echo "<p>Order marked as delivered.</p>";
        // Refresh the page to reflect the updated status
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Order ID: <?php echo $order_id; ?></p>
    <p>Username: <?php echo $order['username']; ?></p>
    <p>Status: <?php echo $order['status']; ?></p>
    <p>Payment Status: <?php echo $order['payment_status']; ?></p>
    <p>Order Date: <?php echo $order['created_at']; ?></p>
    <p>Total Price: $<?php echo number_format($order['total_price'], 2); ?></p>

    <h3>Order Items</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php while ($item = mysqli_fetch_assoc($result_items)) { ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
            </tr>
        <?php } ?>
    </table>

    <!-- Confirm Delivery Button -->
    <?php if ($order['status'] != 'delivered'): ?>
    <form method="POST">
        <button type="submit" name="confirm_delivery">Confirm Delivery</button>
    </form>
    <?php endif; ?>

</body>
</html>

<?php
mysqli_close($conn);
?>
