<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="header.css">
    <script src="addproduct.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #333;
            border: 1px solid #ddd;
            border-bottom: none;
            background: #f9f9f9;
            font-weight: bold;
        }

        .tab.active {
            background: #fff;
            border-top: 2px solid #007bff;
            color: #007bff;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea, button, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f9f9f9;
        }

        #editForm {
            display: none;
            background: #f4f4f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<?php

session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Admin Panel</h1>

        <div class="tabs">
            <div class="tab active" data-target="#add-product">Add Product</div>
            <div class="tab" data-target="#view-products">View Products</div>
            <div class="tab" data-target="#view-users">View Users</div>
            <div class="tab" data-target="#view-orders">View Orders</div>
        </div>

        <div class="tab-content active" id="add-product">
    <h2>Add New Product</h2>
    <form action="addproduct.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <textarea name="category" placeholder="Category" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required> <!-- Add this line -->
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Submit</button>
    </form>
</div>


<div class="tab-content" id="view-products">
    <h2>Available Products</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th> <!-- Add Quantity column -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "registration");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT id, title, description, price, quantity FROM products"; // Include quantity
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td> <!-- Show quantity -->
                        <td>
                            <button onclick=\"openProductEditForm({$row['id']}, '{$row['title']}', '{$row['description']}', '{$row['price']}', '{$row['quantity']}')\">Edit</button>
                            <form action='delete_product.php' method='post' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>


        <div class="tab-content" id="view-users">
            <h2>Total Registered Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "registration");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT id, username, email FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>
                                    <button onclick=\"openEditForm({$row['id']}, '{$row['username']}', '{$row['email']}')\">Edit</button>
                                    <form action='delete_user.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="view-orders">
            <h2>View Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Order Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "registration");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Query to join orders and order_items
                    $sql = "SELECT o.id as order_id, o.username, o.email, oi.product_name, oi.quantity, oi.price, o.total_price, o.status
                            FROM orders o
                            JOIN order_items oi ON o.id = oi.order_id";

                    $result = $conn->query($sql);

                    // Check if the query is successful
                    if ($result) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['order_id']}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['product_name']}</td>
                                        <td>{$row['quantity']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$row['total_price']}</td>
                                        <td>{$row['status']}</td>
                                        <td>
                                            <form action='update_order_status.php' method='post'>
                                                <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                                <select name='status'>
                                                    <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                                    <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                                    <option value='Cancelled' " . ($row['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                                </select>
                                                <button type='submit'>Update Status</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No orders found</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Error fetching orders: " . $conn->error . "</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div id="editForm">
            <h2>Edit Product</h2>
            <form action="edit_product.php" method="post">
                <input type="hidden" name="id" id="edit-product-id">
                <input type="text" name="title" id="edit-title" required>
                <textarea name="description" id="edit-description" required></textarea>
                <input type="number" name="price" id="edit-price" required>
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelector('.tab.active').classList.remove('active');
                tab.classList.add('active');
                const target = tab.getAttribute('data-target');
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === target.substring(1)) {
                        content.classList.add('active');
                    }
                });
            });
        });

        function openProductEditForm(id, title, description, price) {
            document.getElementById('edit-product-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-price').value = price;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
