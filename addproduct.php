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
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);

    // Handle image upload
    if (isset($_FILES['image'])) {
        $upload_dir = "uploads/";
        $image_name = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $image_name;

        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            echo "File uploaded successfully!";

            // Insert data into the database, including the image URL
            $sql = "INSERT INTO products (title, description, price, image_url) 
                    VALUES ('$title', '$description', $price, '$upload_file')";

            if ($conn->query($sql) === TRUE) {
                echo "Product added successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No image uploaded.";
    }
}

$conn->close();
?>