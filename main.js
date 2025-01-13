 // Get all "Add to Cart" buttons
 const addToCartButtons = document.querySelectorAll('.add-to-cart');

 addToCartButtons.forEach(button => {
     button.addEventListener('click', function() {
         const productName = button.getAttribute('data-name');
         const productPrice = button.getAttribute('data-price');

         let cart = JSON.parse(localStorage.getItem('cart')) || [];

         cart.push({ name: productName, price: productPrice });

         localStorage.setItem('cart', JSON.stringify(cart));

         window.location.href = "shop.php";
     });
 });