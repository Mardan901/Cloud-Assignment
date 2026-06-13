<!DOCTYPE html>
<html lang="en">
<header>
    <a href="index.php" class="logo">
        <img src="logo.jpg" alt="JNG Resources Logo">
    </a>
    <nav>
        <?php
        // to see where the current page is 
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>

        <! change text color depending on where the current page is>
            <a href="index.php" <?php if ($current_page == 'index.php') echo 'style="color: var(--accent-gold);"'; ?>>Home</a>
            <a href="about.php" <?php if ($current_page == 'about.php') echo 'style="color: var(--accent-gold);"'; ?>>About Us</a>
            <a href="contact.php" <?php if ($current_page == 'contact.php') echo 'style="color: var(--accent-gold);"'; ?>>Contact Us</a>

            <?php
            // to redirect to other pages depending on what role user is
            if (isset($_SESSION['user_id'])) {
                $dash_link = ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'client_dashboard.php';
                echo '<a href="' . $dash_link . '" class="btn-login">My Dashboard</a>';
                echo '<a href="logout.php" class="btn-login" style="background-color: #cc0000; color: white;">Logout</a>';
            } else {
                echo '<a href="register.html">Register</a>';
                echo '<a href="login.php" class="btn-login">Client Portal Login</a>';
            }
            ?>
    </nav>
</header>

</html>