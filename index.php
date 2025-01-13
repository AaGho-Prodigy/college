<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>

<?php include('header.php');?>
    <section class="hero">
        <div class="container">
            <h1>Find Your Product Here!</h1>
            <p>We provide you with the most affordable electronic goods on the market.</p>
            <a href="shop.php" class="btn">Shop Now</a>
        </div>
    </section>

    <section class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <div class="product-card">
                    <img src="playstation.webp" alt="Product 1">
                    <h3>Product 1</h3>
                    <p>$29.99</p>
                  
                    <button class="btn add-to-cart" data-name="Product 1" data-price="29.99">Add to Cart</button>

                    <a href="#" class="btn">Buy Now</a>
                </div>
                <div class="product-card">
                    <img src="smartwatch2.webp" alt="Product 2">
                    <h3>Product 2</h3>
                    <p>$39.99</p>
                    <button class="btn add-to-cart" data-name="Product 2" data-price="39.99">Add to Cart</button>
                    <a href="#" class="btn">Buy Now</a>
                </div>
                <div class="product-card">
                    <img src="smartwatch3.webp" alt="Product 3">
                    <h3>Product 3</h3>
                    <p>$49.99</p>
                    <button class="btn add-to-cart" data-name="Product 3" data-price="39.99">Add to Cart</button>
                    <a href="#" class="btn">Buy Now</a>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php');?>


    

    
    </footer>
    <script src="products.json"></script>
    <script src="main.js"></script>
</body>
</html>