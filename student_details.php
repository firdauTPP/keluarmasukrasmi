<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "keluarmasuk");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student record ID from the URL
if (isset($_GET['id'])) {
    $record_id = $_GET['id'];
} else {
    die("No record ID provided.");
}

// Query to fetch student details based on record ID
$sql = "SELECT u.username, r.register_number, r.course, r.semester, r.room_number, r.phone_number, r.parent_phone, r.check_out_date, r.check_in_date, r.reason, r.other_details
        FROM records r
        JOIN users u ON r.student_id = u.id
        WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $record_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the record was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 0px;
        }
        h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .details-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .details-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-container th, .details-container td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-container th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .details-container td {
            font-size: 1.1rem;
        }
        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .back-button a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Butiran Pelajar</h2>
    <div class="details-container">
        <table>
            <tr>
                <th>Nama Pengguna</th>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
            </tr>
            <tr>
                <th>Nombor Daftar Pelajar</th>
                <td><?php echo htmlspecialchars($row['register_number']); ?></td>
            </tr>
            <tr>
                <th>Kursus</th>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
            </tr>
            <tr>
                <th>Semester</th>
                <td><?php echo htmlspecialchars($row['semester']); ?></td>
            </tr>
            <tr>
                <th>Nombor Bilik</th>
                <td><?php echo htmlspecialchars($row['room_number']); ?></td>
            </tr>
            <tr>
                <th>Nombor Telefon</th>
                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
            </tr>
            <tr>
                <th>Nombor Telefon Ibubapa / Penjaga</th>
                <td><?php echo htmlspecialchars($row['parent_phone']); ?></td>
            </tr>
            <tr>
                <th>Tarikh Masa Keluar</th>
                <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
            </tr>
            <tr>
                <th>Tarikh Masa Masuk</th>
                <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
            </tr>
            <tr>
                <th>Tujuan Keluar</th>
                <td><?php echo htmlspecialchars($row['reason']); ?></td>
            </tr>
            <tr>
                <th>Sebab Tujuan Keluar Lain</th>
                <td><?php echo htmlspecialchars($row['other_details']); ?></td>
            </tr>
        </table>
    </div>

    <div class="back-button">
        <a href="warden_records.php">Kembali ke Halaman Rekod</a>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
