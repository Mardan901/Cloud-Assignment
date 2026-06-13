<!DOCTYPE html>
<html>

<head>
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f4f7f6;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            border-top: 5px solid #003366;
            margin-bottom: 20px;
        }

        input,
        select,
        textarea {
            width: 100%;
            adding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #003366;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .alert {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* style for quote history */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .status-pending {
            color: red;
            font-weight: bold;
        }

        .status-replied {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="margin: 0;">Welcome to Client Portal, <?php echo $_SESSION['username']; ?>!</h2>
        </div>
        <div>
            <a href="index.php" style="background-color: #003366; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-right: 10px;">🏠 Back to Home</a>

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <span style="background-color: #e0e0e0; color: #999999; padding: 8px 15px; border-radius: 4px; font-weight: bold; margin-right: 10px; cursor: not-allowed;">⚙️ Edit Profile</span>
            <?php } else { ?>
                <a href="profile.php" style="background-color: #ffcc00; color: #003366; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-right: 10px;">⚙️ Edit Profile</a>
            <?php } ?>

            <a href="logout.php" style="background-color: #cc0000; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">Logout</a>
        </div>
    </div>
    <hr>
    <h3>Request a New Quote</h3>

    <?php if ($success_msg != "") {
        echo "<div class='alert'>$success_msg</div>";
    } ?>

    <form method="POST" action="">
        <label>Select a Product/Service:</label>
        <select name="product_id" required>
            <option value="">-- Choose a Product --</option>
            <?php
            while ($row = mysqli_fetch_assoc($products_result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['product_name'] . "</option>";
            }
            ?>
        </select>

        <label>Project Details / Message:</label>
        <textarea name="message" rows="4" required placeholder="Describe your project needs here..."></textarea>

        <?php if ($_SESSION['role'] == 'admin') { ?>
            <p style="color: #cc0000; font-weight: bold; margin-bottom: 10px;">⚠️ Admin Preview Mode: Quote submission is disabled.</p>
            <button type="button" disabled style="background-color: #cccccc; color: #666666; padding: 10px 20px; border: none; border-radius: 4px; cursor: not-allowed;">Send Request (Disabled)</button>
        <?php } else { ?>
            <button type="submit" style="background-color: #003366; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Send Request</button>
        <?php } ?>
    </form>
    </div>

    <div class="dashboard-container">
        <h3>My Quote History</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>My Message</th>
                <th>Status</th>
                <th>Admin Reply</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($history_result)) { ?>
                <tr>
                    <td><?php echo $row['request_date']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td class="<?php echo ($row['status'] == 'Pending') ? 'status-pending' : 'status-replied'; ?>">
                        <?php echo $row['status']; ?>
                    </td>
                    <td>
                        <?php
                        if ($row['status'] == 'Replied') {
                            echo $row['admin_reply'];
                        } else {
                            echo "<em>Awaiting reply...</em>";
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>