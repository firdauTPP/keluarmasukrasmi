<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // Database connection

$message = ""; // Variable to store the success or error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['user_id'];
    $register_number = $_POST['register_number'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $room_number = $_POST['room_number'];
    $phone_number = $_POST['phone_number'];
    $parent_phone = $_POST['parent_phone'];
    $check_out_date = $_POST['check_out_date'];
    $check_in_date = $_POST['check_in_date'];
    $reason = $_POST['reason'];
    $other_details = $_POST['other_details'];
    
    // Get the current date and time
    $current_time = date('Y-m-d H:i:s'); // Format: 2024-10-25 10:34:56

    // Insert into records table
    $sql = "INSERT INTO records (student_id, register_number, course, semester, room_number, phone_number, parent_phone, check_out_date, check_in_date, reason, other_details, request_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssss", $student_id, $register_number, $course, $semester, $room_number, $phone_number, $parent_phone, $check_out_date, $check_in_date, $reason, $other_details, $current_time);
    
    if ($stmt->execute()) {
        $message = "Data successfully submitted!";
        // Redirect to view_records.php after successful submission
        header("Location: view_records.php");
        exit();
    } else {
        $message = "Failed to submit data: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In/Out Form</title>
    <style>
        /* General styling */
        body {
            margin: 10;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form container styling */
        form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            position: relative;
            animation: fadeIn 0.7s ease-in-out;
        }

        input, select, textarea {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #6a11cb;
            outline: none;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        label {
            font-size: 1rem;
            color: #666;
            display: block;
            margin-bottom: 8px;
        }

        /* Button styling with smooth hover effect */
        button {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 168, 71, 0.3);
        }

        /* Success and error message styling */
        .success-message {
            color: green;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Back button styling */
        .btn-back {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            position: absolute;
            top: 20px;
            left: 20px;
            width: 6.8%;
        }

        .btn-back:hover {
            background-color: #0056b3;
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

        /* Animation for form */
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
    </style>
</head>
<body>
    <a href="index.php"><button class="btn-back">Kembali</button></a>

    <form action="student_form.php" method="POST">
        <h2>Borang Keluar / Masuk Pelajar</h2>

        <!-- Display message for success or error -->
        <?php if ($message != ""): ?>
            <div class="<?php echo strpos($message, 'successfully') !== false ? 'success-message' : 'error-message'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <input type="text" name="register_number" placeholder="Nombor Daftar Pelajar" required><br>
        <label for="course">Kursus</label>
        <select name="course" required>
            <option value="Pilih kursus">- Pilih kursus -</option>
            <option value="TPP">TPP</option>
            <option value="TPM">TPM</option>
            <option value="TKR">TKR</option>
            <option value="CADD">CADD</option>
        </select><br>
        <label for="semester">Semester</label>
        <select name="semester" required>
            <option value="Pilih semester berapa">- Pilih semester berapa -</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select><br>
        <input type="text" name="room_number" placeholder="Nombor Bilik" required><br>
        <input type="text" name="phone_number" placeholder="Nombor Telefon" required><br>
        <input type="text" name="parent_phone" placeholder="Nombor Penjaga" required><br>
        <label for="check_out_date">Tarikh Masa Keluar</label>
        <input type="datetime-local" name="check_out_date" required><br>
        <label for="check_in_date">Tarikh Masa Masuk</label>
        <input type="datetime-local" name="check_in_date" required><br>
        <label for="reason">Tujuan Keluar</label>
        <select name="reason" required>
            <option value="Pilih tujuan keluar">- Pilih tujuan keluar -</option>
            <option value="Balik bermalam">Balik bermalam</option>
            <option value="Outing">Outing</option>
            <option value="Cuti sakit">Cuti sakit</option>
            <option value="Lain-lain">Lain-lain</option>
        </select><br>
        <textarea name="other_details" placeholder="Lain-lain (kalau ada)"></textarea><br>
        <button type="submit" onclick="return confirm('Anda Telah Berjaya Menghantar!');">Hantar</button>
    </form>
</body>
</html>
