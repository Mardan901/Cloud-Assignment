<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | JNG Resources Sdn Bhd</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .content-section {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            border-top: 5px solid var(--main-blue);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .contact-info {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <?php include 'nav_function.php'; ?>

    <div class="content-section">
        <h1>Get In Touch</h1>
        <p>Ready to secure your next project? Reach out to our engineering team or log into your Client Portal to request a custom quote for our vertical access products.</p>

        <div class="contact-info">
            <h3>Headquarters</h3>
            <p>📍 No 327 Jalan Reko,43000 Kajang, Selangor, Malaysia</p>
            <p>📞 Phone: +60 16 3288 516</p>
            <p>✉️ Email: hisham.jng@gmail.com

        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> JNG Resources Sdn Bhd All rights reserved. | ARC2263 Project
    </footer>

</body>

</html>
