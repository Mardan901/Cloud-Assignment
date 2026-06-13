<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

//reply to customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['quick_reply']) || isset($_POST['submit_reply']))) {

    // 1. Detect the ID (Did it come from the table button or the hidden input?)
    $quote_id = isset($_POST['quick_reply']) ? $_POST['quick_reply'] : $_POST['quote_id'];
    $quote_id = mysqli_real_escape_string($conn, $quote_id);

    // 2. Detect the Message (Did it come from the dynamic table box or the single edit box?)
    if (isset($_POST['quick_reply'])) {
        $reply_field = 'admin_reply_' . $quote_id;
        $reply = $_POST[$reply_field];
    } else {
        $reply = $_POST['admin_reply'];
    }
    $reply = mysqli_real_escape_string($conn, $reply);

    // 3. Run the ONE database update
    mysqli_query($conn, "UPDATE quotes SET status='Replied', admin_reply='$reply' WHERE id='$quote_id'");

    // 4. Redirect home
    header("Location: admin_dashboard.php");
    exit();
}

//redirect to edit page 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_action'])) {
    if (isset($_POST['quote_to_edit']) && !empty($_POST['quote_to_edit'])) {
        $edit_id = htmlspecialchars($_POST['quote_to_edit']);
        header("Location: edit_quote.php?id=$edit_id");
        exit();
    } else {
        echo "<script>alert('Please select a row using the radio button before clicking Edit.'); window.location.href='admin_dashboard.php';</script>";
        exit();
    }
}

//delete  quote
if (isset($_GET['delete_quote'])) {
    $del_quote = mysqli_real_escape_string($conn, $_GET['delete_quote']);

    // Run the query to delete the quote
    if (mysqli_query($conn, "DELETE FROM quotes WHERE id='$del_quote'")) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting quote: " . mysqli_error($conn);
    }
}

// add  product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    mysqli_query($conn, "INSERT INTO products (product_name, category) VALUES ('$name', '$category')");

    header("Location: admin_dashboard.php");
    exit();
}

// delete  product
if (isset($_GET['delete_product'])) {
    $del_id = mysqli_real_escape_string($conn, $_GET['delete_product']);
    mysqli_query($conn, "DELETE FROM quotes WHERE product_id='$del_id'");
    mysqli_query($conn, "DELETE FROM products WHERE id='$del_id'");

    header("Location: admin_dashboard.php");
    exit();
}

// delete user
if (isset($_GET['delete_user'])) {
    $del_user = mysqli_real_escape_string($conn, $_GET['delete_user']);
    // Delete their quotes first to prevent database constraint errors!
    mysqli_query($conn, "DELETE FROM quotes WHERE client_id='$del_user'");
    // Delete the user
    mysqli_query($conn, "DELETE FROM users WHERE id='$del_user'");

    header("Location: admin_dashboard.php");
    exit();
}

// reply to customer in edit page
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_reply'])) {
    $quote_id = mysqli_real_escape_string($conn, $_POST['quote_id']);
    $reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);
    mysqli_query($conn, "UPDATE quotes SET status='Replied', admin_reply='$reply' WHERE id='$quote_id'");

    header("Location: admin_dashboard.php");
    exit();
}

// to replace existing reply to the updated one
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_reply'])) {
    $quote_id = mysqli_real_escape_string($conn, $_POST['quote_id']);
    $updated_reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);
    mysqli_query($conn, "UPDATE quotes SET admin_reply='$updated_reply' WHERE id='$quote_id'");

    header("Location: admin_dashboard.php");
    exit();
}

// fetch data for tables
$search_query = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = "WHERE product_name LIKE '%$search%' OR category LIKE '%$search%'";
}
$products = mysqli_query($conn, "SELECT * FROM products $search_query");

$quotes_sql = "SELECT quotes.*, users.full_name, products.product_name, users.company_name, users.phone 
               FROM quotes 
               JOIN users ON quotes.client_id = users.id 
               JOIN products ON quotes.product_id = products.id 
               ORDER BY request_date DESC";
$quotes = mysqli_query($conn, $quotes_sql);

//get all clients info
$user_search_filter = "";
if (isset($_GET['search_users']) && !empty($_GET['search_users'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search_users']);
    // Search by username or user ID
    $user_search_filter = " AND (username LIKE '%$search_term%' OR id LIKE '%$search_term%')";
}
$users_sql = mysqli_query($conn, "SELECT id, username, role FROM users WHERE role='client' $user_search_filter");

// THIS IS THE CRITICAL CHANGE: Load the HTML View, not the backend file itself!
include 'admin_dashboard_view.php';
