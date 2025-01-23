<?php
session_start(); // Start the session to check login status
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    
    <?php include 'header.php';?>
           
  

    <section class="hero">
        <div class="container">
            <h1>Find Your Product Here!</h1>
            <p>We provide you with the most affordable electronic goods on the market.</p>
            <a href="shop.html" class="btn">Shop Now</a>
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <h2>Subscribe to our Newsletter</h2>
            <p>Stay updated with the latest deals and offers.</p>
            <form action="#" method="POST">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit" class="btn">Subscribe</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="https://facebook.com">Facebook</a>
                <a href="https://twitter.com">Twitter</a>
                <a href="https://instagram.com">Instagram</a>
            </div>
        </div>
    </footer>
</body>
</html>
