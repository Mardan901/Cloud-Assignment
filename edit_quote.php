<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// get the reply data to prefill the form
if (isset($_GET['id'])) {
    $quote_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM quotes WHERE id = '$quote_id'";
    $result = mysqli_query($conn, $query);
    $quote = mysqli_fetch_assoc($result);
} else {
    header("Location: admin_dashboard.php");
    exit();
}

// submit the data
if (isset($_POST['update_quote'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $new_reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);

    $update_sql = "UPDATE quotes SET status = '$new_status', admin_reply = '$new_reply' WHERE id = '$quote_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Quote updated successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Quote</title>
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
            width: 50%;
            margin: 0 auto;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            text-decoration: none;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-secondary {
            background: grey;
            color: white;
            margin-left: 10px;
        }

        .btn-delete {
            background: #cc0000;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Process Quote #<?php echo $quote['id']; ?></h2>

        <form action="" method="POST">
            <p><strong>Client Message:</strong> <br><?php echo htmlspecialchars($quote['message']); ?></p>

            <label><strong>Status:</strong></label><br>
            <select name="status" style="margin-bottom: 15px; padding: 5px;">
                <option value="Pending" <?php if ($quote['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Replied" <?php if ($quote['status'] == 'Replied') echo 'selected'; ?>>Replied</option>
            </select><br>

            <label><strong>Your Reply / Price Quote:</strong></label><br>
            <textarea name="admin_reply" rows="5" style="width: 100%; margin-bottom: 15px;" required><?php echo htmlspecialchars($quote['admin_reply']); ?></textarea><br>

            <button type="submit" name="update_quote" class="btn btn-success">Save Changes</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
            <a href="admin_dashboard.php?delete_quote=<?php echo $quote['id']; ?>" class="btn btn-delete" onclick="return confirm('WARNING: Are you sure you want to delete this quote?');">Delete</a>
        </form>
    </div>
</body>

</html>