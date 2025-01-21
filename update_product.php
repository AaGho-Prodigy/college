<?php
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $price = $_POST['price'] ?? null;

    if ($id && $title && $description && $price) {
        $sql = "UPDATE products SET title='$title', description='$description', price=$price WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Product updated successfully!";
        } else {
            echo "Error updating product: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
