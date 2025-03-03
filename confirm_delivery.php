<?php if (isset($_GET['success'])): ?>
    <script>
        alert("You have successfully confirmed delivery!");
        window.location.href = "confirm_delivery.php";
    </script>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <script>
        alert("Error confirming delivery. Please try again.");
        window.location.href = "confirm_delivery.php";
    </script>
<?php endif; ?>
