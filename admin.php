<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
<body>
    <div class="container">
        <h1>Admin Panel</h1>

        <div class="tabs">
            <div class="tab active" data-target="#add-product">Add Product</div>
            <div class="tab" data-target="#view-products">View Products</div>
            <div class="tab" data-target="#view-users">View Users</div>
        </div>

        <div class="tab-content active" id="add-product">
            <h2>Add New Product</h2>
            <form action="addproduct.php" method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" name="price" placeholder="Price" required>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "registration");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT id, title, description, price FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>
                            <button onclick=\"openProductEditForm({$row['id']}, '{$row['title']}', '{$row['description']}', '{$row['price']}')\">Edit</button>
                            <form action='delete_product.php' method='post' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <div id="editProductForm" style="display:none; background: #f4f4f9; padding: 20px; border-radius: 8px; margin-top: 20px;">
        <h3>Edit Product</h3>
        <form action="update_product.php" method="post">
            <input type="hidden" name="id" id="productId">
            <label for="productTitle">Title:</label>
            <input type="text" name="title" id="productTitle" required>
            <label for="productDescription">Description:</label>
            <textarea name="description" id="productDescription" required></textarea>
            <label for="productPrice">Price:</label>
            <input type="number" name="price" id="productPrice" required>
            <button type="submit">Update</button>
            <button type="button" onclick="closeProductEditForm()">Cancel</button>
        </form>
    </div>
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

            <div id="editForm">
                <h3>Edit User</h3>
                <form action="update_user.php" method="post">
                    <input type="hidden" name="id" id="userId">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                    <button type="submit">Update</button>
                    <button type="button" onclick="closeEditForm()">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    tab.classList.add('active');
                    document.querySelector(tab.dataset.target).classList.add('active');
                });
            });
        });

        function openEditForm(id, username, email) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('userId').value = id;
            document.getElementById('username').value = username;
            document.getElementById('email').value = email;
        }

        function closeEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
        
        function openProductEditForm(id, title, description, price) {
    document.getElementById('editProductForm').style.display = 'block';
    document.getElementById('productId').value = id;
    document.getElementById('productTitle').value = title;
    document.getElementById('productDescription').value = description;
    document.getElementById('productPrice').value = price;
}

function closeProductEditForm() {
    document.getElementById('editProductForm').style.display = 'none';
}

    </script>
</body>
</html>
