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
        
        //UPDATED SECURITY CHECK (HASHED)
        if ($role === 'admin') {
            $admin_code = $_POST['admin_verification_code'];
            
        
            $stored_hash = '$2y$10$wU0R.Tz6W8Qnbe2fU7/FReK36vC5lU1aDkaL7rC2b0GqN/p7K6vS';
            
            if (!password_verify($admin_code, $stored_hash)) {
                die("<h3 style='color:red;'>Error: Unauthorized admin registration token. Access Denied.</h3> <br><br> <a href='register.html'>Go back</a>");
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
?>
