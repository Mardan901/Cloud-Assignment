<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #eaeaea;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border-top: 5px solid #cc0000;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #003366;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            background: #003366;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-delete {
            background: #cc0000;
        }

        .btn-success {
            background: #28a745;
        }

        textarea {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0;">Admin Control Panel</h1>
            <p style="margin: 5px 0 0 0; color: #555;">Welcome, <?php echo $_SESSION['username']; ?></p>
        </div>
        <div>
            <a href="index.php" style="background-color: #003366; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-right: 10px;">🌐 View Public Site</a>
            <a href="logout.php" style="background-color: #cc0000; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>Client Quote Requests</h2>

        <form method="GET" action="admin_dashboard.php" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search_quotes" placeholder="Search client or company..."
                value="<?php echo isset($_GET['search_quotes']) ? htmlspecialchars($_GET['search_quotes']) : ''; ?>"
                style="padding: 5px; width: 250px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="admin_dashboard.php" class="btn" style="background: grey; color: white; text-decoration: none;">Clear</a>
        </form>

        <form method="POST" action="admin_dashboard.php">

            <div style="margin-bottom: 10px;">
                <button type="submit" name="edit_action" value="edit" class="btn" style="background-color: #ff9800; color: white;">Edit Selected</button>
            </div>

            <table>
                <tr>
                    <th>Select</th>
                    <th>Quote ID</th>
                    <th>Date</th>
                    <th>Client Name</th>
                    <th>Company Name</th>
                    <th>Phone Number</th>
                    <th>Product</th>
                    <th>Client Message</th>
                    <th>Status</th>
                    <th>Admin Reply</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($quotes)) { ?>
                    <tr>
                        <td style="text-align: center;">
                            <input type="radio" name="quote_to_edit" value="<?php echo $row['id']; ?>">
                        </td>

                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['request_date']; ?></td>
                        <td><?php echo (!empty($row['full_name'])) ? $row['full_name'] : '<em>Not provided</em>'; ?></td>
                        <td><?php echo $row['company_name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td style="font-weight:bold; color: <?php echo ($row['status'] == 'Pending') ? 'red' : 'green'; ?>;">
                            <?php echo $row['status']; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <textarea id="reply_box_<?php echo $row['id']; ?>" name="admin_reply_<?php echo $row['id']; ?>" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Type reply here..."></textarea><br>
                                <button type="submit" name="quick_reply" value="<?php echo $row['id']; ?>" class="btn btn-success" style="margin-top: 5px;" onclick="return checkReply(<?php echo $row['id']; ?>);">Send Reply</button>
                            <?php } else {
                                echo htmlspecialchars($row['admin_reply']);
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>

    <div class="container">
        <h2>Manage Product Catalog</h2>
        <form method="POST" action="admin_dashboard.php" style="margin-bottom: 20px; background: #f9f9f9; padding: 10px; border: 1px solid #ccc;">
            <strong>Add New Product:</strong>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <select name="category" required>
                <option value="Facade Access">Facade Access</option>
                <option value="Rooftop Safety">Rooftop Safety</option>
            </select>
            <button type="submit" name="add_product" class="btn">Add to Catalog</button>
        </form>

        <form method="GET" action="admin_dashboard.php" style="margin-bottom: 10px;">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit" class="btn">Search</button>
            <a href="admin_dashboard.php" class="btn" style="background: grey;">Clear</a>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($products)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_product=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('WARNING: Deleting this product will also delete any client quote requests associated with it. Are you absolutely sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="container">
        <h2>Manage Users (Client List)</h2>

        <form method="GET" action="admin_dashboard.php" style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search_users" placeholder="Search by username or ID..."
                value="<?php echo isset($_GET['search_users']) ? htmlspecialchars($_GET['search_users']) : ''; ?>"
                style="padding: 5px; width: 250px;">
            <button type="submit" class="btn btn-primary" style="background-color: #003366; color: white;">Search</button>
            <a href="admin_dashboard.php" class="btn" style="background: grey; color: white; text-decoration: none;">Clear</a>
        </form>

        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Account Type</th>
                <th>Action</th>
            </tr>
            <?php while ($user_row = mysqli_fetch_assoc($users_sql)) { ?>
                <tr>
                    <td><?php echo $user_row['id']; ?></td>
                    <td><?php echo $user_row['username']; ?></td>
                    <td><?php echo ucfirst($user_row['role']); ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_user=<?php echo $user_row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this client account?');">Remove User</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <script src="admin_script.js"></script>
</body>

</html>