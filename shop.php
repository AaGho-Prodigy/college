<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
    <script src="cart.js" async></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .product-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .product-card p {
            font-size: 14px;
            color: #555;
            margin: 10px 0;
        }
        .product-card .price {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .product-card button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .product-card button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "registration");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all products from the database
$sql = "SELECT id, title, description, price, image_url FROM products";
$result = $conn->query($sql);
?>

<div class="container">
    <?php
    // Check if the query returned any products
    if ($result->num_rows > 0) {
        // Loop through each product and create a product card
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
            echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
            echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
            echo '<div class="price">$' . number_format($row["price"], 2) . '</div>';
            echo '<button class="add-to-cart" 
                data-id="' . htmlspecialchars($row["id"]) . '" 
                data-title="' . htmlspecialchars($row["title"]) . '" 
                data-price="' . htmlspecialchars($row["price"]) . '">Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No products available.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Add event listeners to "Add to Cart" buttons
    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", (e) => {
            const productId = e.target.dataset.id;
            const productTitle = e.target.dataset.title;
            const productPrice = parseFloat(e.target.dataset.price);

            // Check if the product is already in the cart
            const existingProduct = cart.find((item) => item.id === productId);
            if (existingProduct) {
                existingProduct.quantity += 1; // Increment quantity
            } else {
                cart.push({
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    quantity: 1,
                });
            }

            // Save updated cart to localStorage
            localStorage.setItem("cart", JSON.stringify(cart));

            alert(`${productTitle} has been added to your cart!`);
        });
    });
});
</script>
</body>
</html>
