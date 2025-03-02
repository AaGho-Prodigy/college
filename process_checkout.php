<?php
session_start();
require 'connect.php'; // Ensure you have a file to connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Error: User not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $cart_data = json_decode($_POST['cart_data'], true);

    if (empty($cart_data)) {
        die("Error: Cart is empty.");
    }

    // Calculate total price
    $total_price = 0;
    foreach ($cart_data as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Insert order
    $conn->begin_transaction();
    try {
        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, payment_status) VALUES (?, ?, 'Pending', 'Unpaid')");
        $stmt->bind_param("id", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id; // Get the last inserted order ID
        $stmt->close();

        // Insert order items into order_items table
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        foreach ($cart_data as $item) {
            $stmt->bind_param("iii", $order_id, $item['id'], $item['quantity']);
            $stmt->execute();
            
            // Reduce quantity in stock
            $updateStock = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            $updateStock->bind_param("ii", $item['quantity'], $item['id']);
            $updateStock->execute();
        }
        $stmt->close();

        // Clear the cart for the user
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        // Redirect to order confirmation page with the order_id
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit(); // Ensure no further script execution after redirection
    } catch (Exception $e) {
        $conn->rollback();
        die("Error processing order: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
