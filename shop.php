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
                <img src="smartwatch1.webp" alt="Product 1">
                <h3>Product 1</h3>
                <p>High-quality electronic gadget with advanced features.</p>
                <div class="price">$29.99</div>
                <button class="btn add-to-cart" data-name="Product 1" data-price="29.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="smartwatch2.webp" alt="Product 2">
                <h3>Product 2</h3>
                <p>Reliable and affordable for everyday use.</p>
                <div class="price">$39.99</div>
                <button class="btn add-to-cart" data-name="Product 2" data-price="39.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="smartwatch3.webp" alt="Product 3">
                <h3>Product 3</h3>
                <p>Stylish and compact design for modern living.</p>
                <div class="price">$49.99</div>
                <button class="btn add-to-cart" data-name="Product 3" data-price="49.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="playstation.webp" alt="Product 4">
                <h3>Product 4</h3>
                <p>Top-notch quality for the tech-savvy user.</p>
                <div class="price">$59.99</div>
                <button class="btn add-to-cart" data-name="Product 4" data-price="59.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="smartwatch1.webp" alt="Product 5">
                <h3>Product 5</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>

            <div class="product-card">
                <img src="smartwatch2.webp" alt="Product 5">
                <h3>Product 6</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="playstation.webp" alt="Product 5">
                <h3>Product 7</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="smartwatch3.webp" alt="Product 5">
                <h3>Product 8</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
            <div class="product-card">
                <img src="smartwatch2.webp" alt="Product 5">
                <h3>Product 9</h3>
                <p>Affordable and durable for long-term use.</p>
                <div class="price">$19.99</div>
                <button class="btn add-to-cart" data-name="Product 5" data-price="19.99">Add to Cart</button>
            </div>
    
           
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

const totalPriceDiv = document.createElement('div');
totalPriceDiv.classList.add('total-price-container');
totalPriceDiv.innerHTML = `
    <p><strong>Total Price:</strong> $<span id="total-price">0.00</span></p>
`;
cartList.appendChild(totalPriceDiv);

const updateTotalPrice = () => {
    const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('total-price').textContent = totalPrice.toFixed(2);
};

cart.forEach((item, index) => {
    item.quantity = item.quantity || 1;

    const cartItem = document.createElement('div');
    cartItem.classList.add('cart-item');
    cartItem.innerHTML = `
        <p><strong>Product:</strong> ${item.name}</p>
        <p><strong>Price:</strong> $<span class="total-price">${(item.price * item.quantity).toFixed(2)}</span></p>
        <p><strong>Quantity:</strong> <span class="quantity">${item.quantity}</span></p>
    `;

    const removeButton = document.createElement('button');
    removeButton.textContent = 'Remove';
    removeButton.classList.add('remove-btn');

    removeButton.addEventListener('click', () => {
        cart.splice(index, 1); 
        localStorage.setItem('cart', JSON.stringify(cart)); 
        cartItem.remove(); 
        updateTotalPrice(); 
    });

    // Create Add More button
    const addButton = document.createElement('button');
    addButton.textContent = 'Add More';
    addButton.classList.add('add-btn');

    addButton.addEventListener('click', () => {
        item.quantity += 1; 
        const totalPrice = item.price * item.quantity; 
        localStorage.setItem('cart', JSON.stringify(cart)); 

        cartItem.querySelector('.quantity').textContent = item.quantity;
        cartItem.querySelector('.total-price').textContent = totalPrice.toFixed(2);

        updateTotalPrice(); 
    });

    cartItem.appendChild(removeButton);
    cartItem.appendChild(addButton);

    cartList.appendChild(cartItem);
});

updateTotalPrice();


</script>
    <script src="cart.js"></script>
    <script src="main.js"></script>

</body>
</html>
