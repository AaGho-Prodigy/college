<?php
session_start(); // Start the session to access session variables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="shop.css">
    <script src="cart.js"></script>
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

<div class="product-container">
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
// Function to filter products based on search and category selection
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

// Function to handle adding items to the cart
document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");

    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productId = button.getAttribute("data-id");
            const productTitle = button.getAttribute("data-title");
            const productPrice = parseFloat(button.getAttribute("data-price"));

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Check if product already exists in the cart
            const existingProductIndex = cart.findIndex(item => item.id === productId);
            if (existingProductIndex !== -1) {
                // Increase quantity if product already in cart
                cart[existingProductIndex].quantity += 1;
            } else {
                // Add new product to cart
                cart.push({
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    quantity: 1
                });
            }

            // Save cart to localStorage
            localStorage.setItem("cart", JSON.stringify(cart));

            alert(`${productTitle} has been added to your cart!`);
        });
    });
});
</script>

</body>
</html>
