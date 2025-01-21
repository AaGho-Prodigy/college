<?php
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $sql = "DELETE FROM products WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Product deleted successfully!";
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    } else {
        echo "Product ID is required.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
