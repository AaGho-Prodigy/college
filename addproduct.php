<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input fields
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = floatval($_POST['price']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;  // Set default value if quantity is not provided

    // Handle image upload
    if (isset($_FILES['image'])) {
        $upload_dir = "uploads/";
        $image_name = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $image_name;

        // Check if the product already exists
        $check_sql = $conn->prepare("SELECT id, quantity FROM products WHERE title = ?");
        if ($check_sql === false) {
            echo "Error preparing query: " . $conn->error;
            exit();
        }

        $check_sql->bind_param("s", $title);
        if (!$check_sql->execute()) {
            echo "Error executing query: " . $conn->error;
            exit();
        }

        $check_result = $check_sql->get_result();

        if ($check_result->num_rows > 0) {
            // Product exists, update the quantity
            $existing_product = $check_result->fetch_assoc();
            $new_quantity = $existing_product['quantity'] + $quantity; // Add the new quantity

            // Update the product's quantity
            $update_sql = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
            $update_sql->bind_param("ii", $new_quantity, $existing_product['id']);
            if ($update_sql->execute()) {
                echo "Product quantity updated successfully!";
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
        } else {
            // Product doesn't exist, insert a new product
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                echo "File uploaded successfully!";

                // Insert data into the database, including the image URL and quantity
                $insert_sql = $conn->prepare("INSERT INTO products (title, description, price, image_url, category, quantity) VALUES (?, ?, ?, ?, ?, ?)");
                $insert_sql->bind_param("ssdssi", $title, $description, $price, $upload_file, $category, $quantity);

                if ($insert_sql->execute()) {
                    echo "Product added successfully!";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        }
    } else {
        echo "No image uploaded.";
    }
}

$conn->close();
?>
