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
$cart_query = "SELECT c.product_id, c.quantity, p.price 
               FROM cart c
               JOIN products p ON c.product_id = p.id
               WHERE c.user_id = '$user_id'";

$cart_result = mysqli_query($conn, $cart_query);

if (!$cart_result || mysqli_num_rows($cart_result) == 0) {
    die("Cart is empty.");
}

$total_price = 0;
$order_items = [];

while ($row = mysqli_fetch_assoc($cart_result)) {
    $order_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// Insert into orders
$order_query = "INSERT INTO orders (user_id, total_price, status, payment_status, created_at)
                VALUES ('$user_id', '$total_price', 'pending', 'unpaid', NOW())";

if (mysqli_query($conn, $order_query)) {
    $order_id = mysqli_insert_id($conn);

    // Insert order items
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity) 
                             VALUES ('$order_id', '$product_id', '$quantity')");
    }

    // Clear cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

    // Redirect to order confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
