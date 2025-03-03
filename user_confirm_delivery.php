<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND status = 'pending'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delivery</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Confirm Delivery</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>$<?= $row['total_price'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <form action="process_confirm_delivery.php" method="POST">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <button type="submit">Confirm Delivery</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No pending orders to confirm.</p>
<?php endif; ?>

</body>
</html>

<?php mysqli_close($conn); ?>
