<?php
session_start();
require 'db.php';  // Ensure your database connection is configured correctly

// Initialize message variable
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    
    // Hardcoded credentials for Warden
    $wardenUsername = 'Encik Fahmi';
    $wardenPassword = '123';
    $wardenRole = 'warden';
    
    // Check if the user is trying to log in as Warden
    if ($user_type == 'warden') {
        // Check if the credentials match the hardcoded Warden
        if ($username == $wardenUsername && $password == $wardenPassword) {
            // Set session variables for warden
            $_SESSION['user_id'] = 1;  // Hardcoded Warden ID
            $_SESSION['username'] = $wardenUsername;
            $_SESSION['role'] = $wardenRole;

            // Redirect to warden's page
            header("Location: indexwarden.php");
            exit();
        } else {
            // If anyone else tries to log in as warden, display error message
            $message = "Pilihan pengguna tidak sah.";  // Invalid user type
        }
    } 
    
    // If the user is a student (pelajar)
    else {
        // Check the database for student credentials
        $sql = "SELECT * FROM users WHERE username='$username' AND user_type='pelajar'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            // If student login is successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['user_type'];

            // Redirect to student's page
            header("Location: index.php");
            exit();
        } else {
            // If username or password is incorrect for student
            $message = "Tidak sah nama pengguna atau kata laluan.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* General body styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #10afe1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form container */
        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #207e9b;
        }

        /* Input styles */
        input, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="password"] {
            font-family: 'Arial', sans-serif;
        }

        /* Button styles */
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Link style */
       form a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            text-align: center;
        }

        form a:hover {
            text-decoration: underline;
        }

        /* Message style */
        .message {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            form {
                padding: 20px;
                max-width: 90%;
            }

            h2 {
                font-size: 1.8rem;
            }

            button {
                font-size: 1.1rem;
            }
        }
        .logo {
            position: absolute;
            top: 50px;
            left: 100px;
            width: 140px; /* Adjust size as needed */
            height: auto;
        }
        .logo1 {
            position: absolute;
            top: 50px;
            right: 100px;
            width: 105px; /* Adjust size as needed */
            height: auto;
        }
    </style>
</head>
<body>
<img src="gambar/logo_jtm-removebg-preview.png" alt="Logo" class="logo">
<img src="gambar/images-removebg-preview.png" alt="Logo" class="logo1">
    
    <form action="login.php" method="POST">
        <h2>Login</h2>
        <div class="message">
            <?php if (!empty($message)) { echo $message; } ?>
        </div>
        <label for="user_type">Pilih Jenis Pengguna</label>
        <br>
        <br>
        <select name="user_type" required>
            <option value="pelajar">Pelajar</option>
            <option value="warden">Warden</option>
        </select><br>
        <input type="text" name="username" placeholder="Nama pengguna" required><br>
        <input type="password" name="password" placeholder="Kata laluan" required><br>
        <button type="submit">Login</button>
        <a href="signup.php">Tidak mempunyai akaun? Daftar</a>
    </form>
</body>
</html>
