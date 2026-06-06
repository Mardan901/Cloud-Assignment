<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f9; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .success-container { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            text-align: center; 
            max-width: 450px; 
            width: 100%; 
            border-top: 5px solid #28a745; 
        }
        .checkmark { 
            font-size: 60px; 
            color: #28a745; 
            margin-bottom: 10px; 
        }
        h1 { 
            color: #333; 
            margin-bottom: 10px; 
            font-size: 24px;
        }
        p { 
            color: #666; 
            line-height: 1.6; 
            margin-bottom: 30px; 
            font-size: 15px;
        }
        .btn { 
            display: inline-block; 
            background-color: #003366; 
            color: white; 
            padding: 12px 25px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 16px;
            transition: background-color 0.3s; 
        }
        .btn:hover { 
            background-color: #002244; 
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="checkmark">✓</div>
    <h1>Registration Successful!</h1>

    <?php 
// default to client rike if user did not choose
$user_role = isset($_GET['role']) ? $_GET['role'] : 'client';

if($user_role == 'admin'){
    echo "<p>Welcome aboard! Your admin account has been securely created.</p>";
} else {
    echo "<p>Welcome aboard! Your client account has been securely created.</p>";
}
?>

    <p><strong>Next Step:</strong> Please log in to complete your profile with your Real Name and Company details so you can start requesting quotes.</p>
    
    <a href="login.php" class="btn">Proceed to Login &rarr;</a>
</div>

</body>
</html>