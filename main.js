 // Get all "Add to Cart" buttons
 const addToCartButtons = document.querySelectorAll('.add-to-cart');

 // Add event listener to each "Add to Cart" button
 addToCartButtons.forEach(button => {
     button.addEventListener('click', function() {
         // Get product name and price from the button's data attributes
         const productName = button.getAttribute('data-name');
         const productPrice = button.getAttribute('data-price');

         // Get the current cart from localStorage, or initialize it if it doesn't exist
         let cart = JSON.parse(localStorage.getItem('cart')) || [];

         // Add the product to the cart array
         cart.push({ name: productName, price: productPrice });

         // Save the updated cart to localStorage
         localStorage.setItem('cart', JSON.stringify(cart));

         // Optionally, you can redirect to shop.php to view the cart
         window.location.href = "shop.php";
     });
 });