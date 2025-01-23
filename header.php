<header class="header">
        <div class="container" style="display: flex; justify-content: space-around;">
            <div class="logo">
                <a href="index.php">Your Store Name</a>
            </div>
            <div><nav class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="registration.php">Register</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
            <div class="cart">
                <a href="cart.php">Cart</a>
            </div>
            <div class="auth-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- If logged in, show a welcome message and logout link -->
                    <span>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="logout.php" class="btn">Logout</a>
                <?php else: ?>
                    <!-- If not logged in, show the login link -->
                    <a href="login.php" class="btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </header>