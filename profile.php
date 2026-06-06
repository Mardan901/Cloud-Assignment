<?php
session_start();
require 'db.php';

// make sure user actually logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// update profile once user click save
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Update the database with the new information
    $update_sql = "UPDATE users SET full_name='$full_name', company_name='$company_name', phone='$phone' WHERE id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_msg = "Profile updated successfully!";
    } else {
        $error_msg = "Error updating profile: " . mysqli_error($conn);
    }
}

// fetch user current data
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #003366;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #002244;
        }

        .success {
            color: green;
            background: #e8f5e9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            background: #ffebee;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit My Profile</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?> <em>(Cannot be changed)</em></p>

        <?php if (isset($success_msg)) echo "<div class='success'>$success_msg</div>"; ?>
        <?php if (isset($error_msg)) echo "<div class='error'>$error_msg</div>"; ?>

        <form action="profile.php" method="POST">

            <label for="full_name">Real / Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="e.g., Wan">

            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($user['company_name'] ?? ''); ?>">

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

            <button type="submit" name="update_profile" class="btn">Save Profile Updates</button>
        </form>

        <br>
        <a href="index.php" style="display: block; text-align: center; color: #555; text-decoration: none;">&larr; Back to Home</a>
    </div>

</body>

</html>