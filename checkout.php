<?php
session_start();
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="checkout.js" async></script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .cart-items, .payment-info {
            margin-top: 20px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>


<div class="checkout-container">
    <h1>Checkout</h1>
    
    <form id="checkout-form" action="process_checkout.php" method="POST">
        <section class="billing-info">
            <h2>Billing Information</h2>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="username" value="<?php echo $username; ?>" readonly>
            
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="address">Shipping Address:</label>
            <textarea id="address" name="address" required></textarea>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
        </section>
        
        <section class="cart-items">
            <h2>Your Cart</h2>
            <div id="cart-items"></div>
            <div class="cart-total" id="cart-total">Total: $0.00</div>
            <input type="hidden" name="cart_data" id="cart_data">
        </section>

        <section class="payment-info">
            <h2>Payment Information</h2>
            <p>Payment Method: Cash on Delivery</p>
        </section>

        <button type="submit">Place Order</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartItemsContainer = document.getElementById("cart-items");
        const cartTotalElement = document.getElementById("cart-total");
        const cartDataInput = document.getElementById("cart_data");
        
        function renderCart() {
            cartItemsContainer.innerHTML = "";
            let total = 0;
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
                cartTotalElement.textContent = "Total: $0.00";
                return;
            }
            cart.forEach((item) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const cartItem = document.createElement("div");
                cartItem.classList.add("cart-item");
                cartItem.innerHTML = `
                    <h4>${item.title} (x${item.quantity})</h4>
                    <span class="price">$${itemTotal.toFixed(2)}</span>
                `;
                cartItemsContainer.appendChild(cartItem);
            });
            cartTotalElement.textContent = `Total: $${total.toFixed(2)}`;
            cartDataInput.value = JSON.stringify(cart);
        }

        document.getElementById("checkout-form").addEventListener("submit", function () {
            localStorage.removeItem("cart"); // Clear cart after placing order
        });

        renderCart();
    });
</script>
</body>
</html>