<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Main body styling with gradient background */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f4f4f4;
            overflow: hidden;
        }

        /* Header and footer styling with subtle shadow */
        header, footer {
            width: 100%;
            background-color: #007BFF;
            color: white;
            padding: 25px 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-size: 1.2em;
            letter-spacing: 1px;
            position: relative;
        }
        header {
            height: 65px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-size: 1.2em;
            letter-spacing: 1px;
        }

        /* Moving header text */
        .moving-header {
            position: absolute;
            width: 100%;
            animation: moveText 10s linear infinite;
            white-space: nowrap; /* Prevents text from wrapping */
        }

        @keyframes moveText {
            0% {
                transform: translateX(100%); /* Start from the right */
            }
            100% {
                transform: translateX(-100%); /* Move to the left */
            }
        }

        /* Enhanced container styling */
        .container {
            text-align: center;
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
            margin-top: 110px;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.8s ease-out;
        }

        h1 {
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        a {
            text-decoration: none;
        }

        /* Button styling with hover animation */
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 123, 255, 0.5);
        }

        .btn-logout {
            background-color: red;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
        }

        .btn-logout:hover {
            background-color: #922727;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255, 0, 0, 0.5);
        }

        /* Logo positioning */
        .logo {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 120px;
            height: auto;
            opacity: 0.9;
        }

        .logo1 {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 90px;
            height: auto;
            opacity: 0.9;
        }

        /* Keyframes for fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                margin-top: 70px;
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.5em;
            }

            .logo, .logo1 {
                width: 80px;
                top: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <img src="gambar/logo_jtm-removebg-preview.png" alt="Logo" class="logo">
        <img src="gambar/images-removebg-preview.png" alt="Logo" class="logo1">
        <div class="moving-header">
            <h2>Selamat Datang, Warden!</h2>
        </div>
    </header>

    <!-- Main Content Section -->
    <div class="container">
        <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
        
        <!-- Button for student to fill form -->
        <a href="warden_records.php">
            <button>Rekod Pandangan Warden</button>
        </a>
    </div>

    <!-- Logout Button -->
    <div style="text-align: center; margin-top: 10px;"> <!-- Reduced margin-top -->
        <a href="logout.php">
            <button class="btn-logout">Log Keluar</button>
        </a>
    </div>

    <!-- Footer Section -->
    <footer>
        Hak Cipta Terpelihara &copy; <?php echo date("Y"); ?>  
    </footer>
</body>
</html>
