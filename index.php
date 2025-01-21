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
    <header class="header">
        <div class="container" style="display: flex; justify-content: space-around;">
            <div class="logo">
                <a href="#">Your Store Name</a>
            </div>
            <div><nav class="navbar">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="registration.php">Register</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
            <div class="cart">
                <a href="cart.html">Cart</a>
            </div>
        </div>
    </header>

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