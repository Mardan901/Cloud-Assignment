<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['user_id'];
$success_msg = "";

// submit new quote
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //check if user has full name
    $check_user = mysqli_query($conn, "SELECT full_name FROM users WHERE id = '$client_id'");
    $user_data = mysqli_fetch_assoc($check_user);

    // if empty redirect user to profile.php
    if (empty($user_data['full_name'])) {
        echo "<script>
                alert('Action Required: Please update your Real/Full Name in your profile before sending a quote request.');
                window.location.href = 'profile.php';
              </script>";
        exit();
    }

    // submit the quote
    $product_id = $_POST['product_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO quotes (client_id, product_id, message) VALUES ('$client_id', '$product_id', '$message')";

    if (mysqli_query($conn, $sql)) {
        $success_msg = "Your quote request has been sent to the admin!";
    } else {
        $success_msg = "Error: " . mysqli_error($conn);
    }
}

// fetch products for dropdown option
$products_query = "SELECT id, product_name FROM products";
$products_result = mysqli_query($conn, $products_query);

// tech user quote history
$history_query = "SELECT quotes.*, products.product_name 
                  FROM quotes 
                  JOIN products ON quotes.product_id = products.id 
                  WHERE client_id='$client_id' 
                  ORDER BY request_date DESC";
$history_result = mysqli_query($conn, $history_query);

include 'client_dashboard_view.php';
