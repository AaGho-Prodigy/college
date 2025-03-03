<?php if (isset($_GET['success'])): ?>
    <script>
        alert("Order successfully marked as completed!");
        window.location.href = "admin_orders.php";
    </script>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <script>
        alert("Error updating order. Please try again.");
        window.location.href = "admin_orders.php";
    </script>
<?php endif; ?>
