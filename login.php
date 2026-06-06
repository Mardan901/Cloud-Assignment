<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    // check if username exist
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // check if user input the right password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            //redirect user to appropriate page
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "Username not found. Please register first.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - JNG Resources Sdn Bhd</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 5px solid #003366;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #ffcc00;
            color: #333;
            font-weight: bold;
            font-size: 16px;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #e6b800;
        }

        .error-msg {
            color: #d9534f;
            margin-bottom: 15px;
            font-weight: bold;
        }

        a {
            color: #003366;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Account Login</h2>

        <?php if (isset($error)) {
            echo "<div class='error-msg'>$error</div>";
        } ?>

        <form method="POST" action="">
            <label style="text-align: left; display: block; font-weight: bold; color: #555;">Username:</label>
            <input type="text" name="username" required>

            <label style="text-align: left; display: block; font-weight: bold; color: #555;">Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p style="margin-top: 20px; font-size: 14px;">Don't have an account? <a href="register.html">Register here</a>.</p>
    </div>

</body>

</html>
