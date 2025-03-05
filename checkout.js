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
        cartDataInput.value = JSON.stringify(cart); // ✅ Send cart data to PHP
    }

    document.getElementById("checkout-form").addEventListener("submit", function () {
        localStorage.removeItem("cart"); // ❌ Prevent clearing too soon
    });

    renderCart();
});
