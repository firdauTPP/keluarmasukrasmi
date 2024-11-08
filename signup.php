<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        /* Full page background */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #5ebd61, #3bdb40); /* Gradient background */
        }

        .form-container {
    background-color: #ffffff; /* Change to red */
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    position: relative; /* For positioning the logo */
}

        

        /* Logo styling */
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

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #10b512;
        }

        label {
            font-size: 1rem;
            color: #666;
            display: block;
            margin-bottom: 10px;
        }

        input, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
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
            background-color: #218838;
        }

        .form-container p {
            text-align: center;
        }

        .form-container p a {
            color: #007BFF;
            text-decoration: none;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .form-container {
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
    </style>
</head>
<body>
    <img src="gambar/logo_jtm-removebg-preview.png" alt="Logo" class="logo">
    <img src="gambar/images-removebg-preview.png" alt="Logo" class="logo1">
    <!-- Form Container with Background -->
    <div class="form-container">
        
        
        <form action="signup.php" method="POST">
            <h2>Daftar</h2>
            <label for="user_type">Pilih Jenis Pengguna</label>
            <select name="user_type" required>
                <option value="pelajar">Pelajar</option>
                <option value="warden">Warden</option>
            </select><br>

            <input type="text" name="username" placeholder="Nama pengguna" required><br>
            <input type="password" name="password" placeholder="Kata laluan" required><br>
            <button type="submit">Daftar</button>
            <center>
            <p>Sudah mempunyai akaun? <a href="login.php">Log Masuk di sini</a></p>
            </center>
        </form>
    </div>
</body>
</html>
