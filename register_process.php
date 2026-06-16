<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $check_query = "SELECT * FROM users WHERE username='$username'";

    $check_result = mysqli_query($conn, $check_query);

    // check if theres same username
    if (mysqli_num_rows($check_result) > 0) {
        echo "<h3 style='color:red;'>Error: That username is already taken!</h3>";
        echo "<a href='register.html'>Click here to try a different one.</a>";
    } else {
        
        if ($role === 'admin') {
            $admin_code = $_POST['admin_verification_code'];
            if ($admin_code !== 'STEEL_ADMIN_2026') {
                die("<h3 style='color:red;'>Error: Unauthorized admin registration attempt. Invalid secret code.</h3> <br><br> <a href='register.html'>Go back</a>");
            }
        }
        // --- END SECURITY CHECK ---

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role) 
                VALUES ('$username', '$hashed_password', '$role')";

        if (mysqli_query($conn, $sql)) {
            header("Location: register_success.php?role=$role");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
