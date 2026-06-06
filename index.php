<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JNG Resources Sdn Bhd | Vertical Access Solutions</title>
    <link rel="stylesheet" href="style.css">

    <! custom styling for only index>
        <style>
            .hero {
                padding: 100px 50px;
                text-align: center;
                background-color: white;
                border-bottom: 5px solid var(--main-blue);
            }

            .hero h1 {
                color: var(--main-blue);
                font-size: 52px;
                margin-bottom: 20px;
                margin-top: 0;
            }

            .hero p {
                font-size: 20px;
                max-width: 800px;
                margin: 0 auto 40px;
                line-height: 1.6;
                color: #555;
            }

            .hero .cta-btn {
                background-color: var(--main-blue);
                color: white;
                padding: 15px 35px;
                font-size: 18px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                display: inline-block;
                transition: 0.3s;
            }

            .hero .cta-btn:hover {
                background-color: #001f3f;
            }

            .section-title {
                text-align: center;
                margin: 60px 0 20px;
                color: var(--main-blue);
                font-size: 36px;
            }

            .grid-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 30px;
                max-width: 1200px;
                margin: 0 auto 60px;
                padding: 0 50px;
            }

            .card {
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s;
                border-bottom: 4px solid var(--main-blue);
            }

            .card:hover {
                transform: translateY(-8px);
                border-bottom-color: var(--accent-gold);
            }

            .card img {
                width: 100%;
                height: 220px;
                object-fit: cover;
                background-color: #e9ecef;
            }

            .card-content {
                padding: 25px;
            }

            .card-content h3 {
                margin: 0 0 10px;
                color: var(--main-blue);
                font-size: 22px;
            }

            .card-content p {
                color: #666;
                font-size: 15px;
                line-height: 1.6;
                margin: 0;
            }
        </style>
</head>

<body>
    <?php include 'nav_function.php'; ?>

    <main class="hero">
        <h1>Elevating Safety & Access Solutions</h1>
        <p>Industry-leading facade access equipment and rooftop safety systems. We provide secure, efficient, and reliable infrastructure for your most demanding construction and maintenance projects.</p>

        <! to identify if user is log in or not>
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <a href="register.html" class="cta-btn">Create an Account to Request a Quote</a>
            <?php } else { ?>
                <a href="client_dashboard.php" class="cta-btn">Request a New Quote</a>
            <?php } ?>
    </main>

    <h2 class="section-title">Featured Installations & Products</h2>
    <div class="grid-container">

        <div class="card">
            <img src="project1.jpg" alt="Commercial BMU System">
            <div class="card-content">
                <h3>Commercial BMU Systems</h3>
                <p>Custom-engineered Building Maintenance Units ensuring 100% safe facade access for high-rise commercial towers.</p>
            </div>
        </div>

        <div class="card">
            <img src="project2.jpg" alt="Rooftop Fall Protection">
            <div class="card-content">
                <h3>Rooftop Fall Protection</h3>
                <p>Comprehensive guardrail systems, lifeline networks, and anchor points built to strict compliance standards.</p>
            </div>
        </div>

        <div class="card">
            <img src="project3.jpg" alt="Custom Steel Fabrication">
            <div class="card-content">
                <h3>Custom Steel Access Platforms</h3>
                <p>Heavy-duty, weather-resistant steel catwalks and platforms fabricated precisely for industrial environments.</p>
            </div>
        </div>

    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> JNG Resources Sdn Bhd All rights reserved. | SWC2703 Project
    </footer>

</body>

</html>