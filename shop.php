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

// Fetch all categories
$categoryQuery = "SELECT DISTINCT category FROM products";
$categoryResult = $conn->query($categoryQuery);
?>

<div style="padding: 20px;">
    <input type="text" id="searchInput" placeholder="Search products..." onkeyup="filterProducts()" style="padding: 10px; width: 250px;">
    <select id="categoryFilter" onchange="filterProducts()" style="padding: 10px; margin-left: 10px;">
        <option value="">All Categories</option>
        <?php while ($catRow = $categoryResult->fetch_assoc()) { ?>
            <option value="<?php echo htmlspecialchars($catRow['category']); ?>">
                <?php echo htmlspecialchars($catRow['category']); ?>
            </option>
        <?php } ?>
    </select>
</div>

<div class="container">
    <?php
    // Fetch all products
    $sql = "SELECT id, title, description, price, image_url, category, quantity FROM products";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card" data-category="' . htmlspecialchars($row["category"]) . '">';
            echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
            echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
            echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
            echo '<p class="category">' . htmlspecialchars($row["category"]) . '</p>';
            echo '<p>Stock: ' . htmlspecialchars($row["quantity"]) . '</p>';
            echo '<div class="price">$' . number_format($row["price"], 2) . '</div>';
            echo '<button class="add-to-cart" data-id="' . htmlspecialchars($row["id"]) . '" data-title="' . htmlspecialchars($row["title"]) . '" data-price="' . htmlspecialchars($row["price"]) . '">Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No products available.</p>';
    }
    
    $conn->close();
    ?>
</div>

<?php include 'footer.php'; ?>

<script>
function filterProducts() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase();
    const selectedCategory = document.getElementById("categoryFilter").value;
    
    document.querySelectorAll(".product-card").forEach((card) => {
        const title = card.querySelector("h3").textContent.toLowerCase();
        const description = card.querySelector("p").textContent.toLowerCase();
        const category = card.dataset.category;

        const matchesSearch = title.includes(searchValue) || description.includes(searchValue);
        const matchesCategory = selectedCategory === "" || category === selectedCategory;

        card.style.display = matchesSearch && matchesCategory ? "block" : "none";
    });
}
</script>
</body>
</html>
