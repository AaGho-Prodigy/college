<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="footer.css">
    <style>
       
    </style>
</head>
<body>
<?php include('header.php');?>

    <main class="shop-container">
        <h1>Our Products</h1>
        <div class="product-grid">
            <div class="product-card">
                <img src="product1.webp" alt="Product 1">
                <h3>Product 1</h3>
                <p>High-quality electronic gadget with advanced features.</p>
                <div class="price">$29.99</div>
                <button class="btn add-to-cart" data-name="Product 1" data-price="29.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="product2.webp" alt="Product 2">
                <h3>Product 2</h3>
                <p>Reliable and affordable for everyday use.</p>
                <div class="price">$39.99</div>
                <button class="btn add-to-cart" data-name="Product 2" data-price="39.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="product3.webp" alt="Product 3">
                <h3>Product 3</h3>
                <p>Stylish and compact design for modern living.</p>
                <div class="price">$49.99</div>
                <button class="btn add-to-cart" data-name="Product 3" data-price="49.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="product4.webp" alt="Product 4">
                <h3>Product 4</h3>
                <p>Top-notch quality for the tech-savvy user.</p>
                <div class="price">$59.99</div>
                <button class="btn add-to-cart" data-name="Product 4" data-price="59.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="product5.webp" alt="Product 5">
                <h3>Product 5</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="product5.webp" alt="Product 5">
                <h3>Product 6</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="product5.webp" alt="Product 5">
                <h3>Product 7</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="product5.webp" alt="Product 5">
                <h3>Product 8</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="product5.webp" alt="Product 5">
                <h3>Product 9</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
           
        </div>

       

    <div id="cart" class="cartTab">
        <h1> Shopping Cart</h1>
        <div class="listCart">
   
    </div>
    <div class="cartbtn">
        <button class="close">Close</button>
        <button class="checkOut">Check Out</button>
    </div>
</div>

<?php include('footer.php');?>

    
    </main>
    <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const cartList = document.querySelector('.listCart');

    cart.forEach(item => {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <p><strong>Product:</strong> ${item.name}</p>
            <p><strong>Price:</strong> $${item.price}</p>
        `;
        cartList.appendChild(cartItem);
    });
</script>
    <script src="cart.js"></script>
    <script src="main.js"></script>

</body>
</html>
