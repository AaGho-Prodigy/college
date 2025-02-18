<?php
session_start();
include 'connect.php'; // Ensure this file properly connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $cart_data = json_decode($_POST['cart_data'], true); // Decode the cart data from JSON

    if (!$cart_data || count($cart_data) === 0) {
        die("Error: Cart is empty!");
    }

    // Insert order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (username, email, address, phone, total_price, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    if (!$stmt) {
        die("Error preparing statement for orders: " . $conn->error);
    }

    // Calculate total price
    $total_price = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $cart_data));

    // Bind parameters for order insertion
    $stmt->bind_param("ssssd", $username, $email, $address, $phone, $total_price);

    // Execute the statement
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the last inserted order ID

        // Insert each product into the purchased_products table
        foreach ($cart_data as $item) {
            // Insert the product into the purchased_products table
            $stmt = $conn->prepare("INSERT INTO purchased_products (product_name, quantity, price, order_id) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Error preparing statement for purchased_products: " . $conn->error);
            }
            $stmt->bind_param("sidi", $item['title'], $item['quantity'], $item['price'], $order_id);

            if (!$stmt->execute()) {
                die("Error executing statement for purchased product: " . $stmt->error);
            }

            // Remove the product from the cart table (or mark as purchased)
            // Assuming you have a cart table where products are saved before checkout
            $stmt = $conn->prepare("DELETE FROM cart WHERE product_name = ?"); // Adjust according to your cart table
            if (!$stmt) {
                die("Error preparing statement for cart deletion: " . $conn->error);
            }
            $stmt->bind_param("s", $item['title']); // Assuming 'title' is the unique product identifier

            if (!$stmt->execute()) {
                die("Error deleting product from cart: " . $stmt->error);
            }
        }

        // After successful order and product insertion, you can clear the cart (optional)
        echo "success"; // Response for JavaScript
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
