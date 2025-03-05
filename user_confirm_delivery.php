<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login instead of dying
    exit();
}

$user_id = $_SESSION['user_id'];

// Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM orders WHERE user_id = ? AND status = 'pending'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Error handling for query failure
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
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
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td>$<?= number_format($row['total_price'], 2) ?></td>
                <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                <td>
                    <form action="process_confirm_delivery.php" method="POST">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['id']) ?>">
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

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>