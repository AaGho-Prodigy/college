<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['cart_data'])) {
    die("No cart data received.");
}

$cart_data = json_decode($_POST['cart_data'], true);
if (!$cart_data || count($cart_data) === 0) {
    die("Cart is empty.");
}

// Calculate total price
$total_price = 0;
foreach ($cart_data as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Insert order with explicit status
$order_query = "INSERT INTO orders (user_id, total_price, status, payment_status, created_at)
                VALUES (?, ?, 'pending', 'unpaid', NOW())"; // Explicit status/payment_status

$stmt = mysqli_prepare($conn, $order_query);
mysqli_stmt_bind_param($stmt, 'id', $user_id, $total_price);

if (mysqli_stmt_execute($stmt)) {
    $order_id = mysqli_insert_id($conn);

    // Insert order items
    $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity) 
                         VALUES (?, ?, ?)";
    $stmt_items = mysqli_prepare($conn, $order_item_query);

    foreach ($cart_data as $item) {
        mysqli_stmt_bind_param($stmt_items, 'iii', $order_id, $item['id'], $item['quantity']);
        if (!mysqli_stmt_execute($stmt_items)) {
            die("Error inserting order item: " . mysqli_error($conn));
        }

        // Update product quantity
        $update_quantity_query = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $update_quantity_query);
        mysqli_stmt_bind_param($stmt_update, 'ii', $item['quantity'], $item['id']);
        mysqli_stmt_execute($stmt_update);
    }

    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
} else {
    die("Order creation failed: " . mysqli_error($conn)); // Detailed error
}

mysqli_close($conn);
?>