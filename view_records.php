<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // Include your database connection

// Fetch records from the database, including 'other_details' if reason is 'Lain-lain'
$sql = "SELECT reason, other_details, check_out_date, check_in_date, status FROM records WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']); // Assuming user_id is of integer type
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-size: 2.5rem;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn 0.7s ease-in-out;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Status coloring */
        .status-pending {
            background-color: yellow;
            color: black;
        }
        
        .status-accepted {
            background-color: green;
            color: white;
        }
        
        .status-rejected {
            background-color: red;
            color: white;
        }

        /* Button styling */
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            display: block;
            margin: 20px auto;
            text-decoration: none;
            float: left;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .gray-text {
            color: gray;
            font-style: italic;
            text-align: center;
        }

        /* Animation for table */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            th, td {
                padding: 10px;
            }

            button {
                width: 90%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <a href="index.php"><button>Kembali</button></a>
    <h1>Rekod Pelajar</h1>

    <table>
        <tr>
            <th>Tujuan Keluar</th>
            <th>Tarikh Masa Keluar</th>
            <th>Tarikh Masa Masuk</th>
            <th>Status</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php 
                        // If reason is 'Lain-lain', display the additional details
                        if ($row['reason'] == 'Lain-lain') {
                            echo 'Lain-lain (' . htmlspecialchars($row['other_details']) . ')';
                        } else {
                            echo htmlspecialchars($row['reason']);
                        }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
                <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                <td class="<?php 
                    // Assign the class based on the status
                    if ($row['status'] == 'pending') {
                        echo 'status-pending';
                    } elseif ($row['status'] == 'accepted') {
                        echo 'status-accepted';
                    } elseif ($row['status'] == 'rejected') {
                        echo 'status-rejected';
                    }
                ?>">
                <?php 
                    // Translate status into Malay
                    if ($row['status'] == 'pending') {
                        echo 'Menunggu';
                    } elseif ($row['status'] == 'accepted') {
                        echo 'Diterima';
                    } elseif ($row['status'] == 'rejected') {
                        echo 'Ditolak';
                    }
                ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="gray-text">Tiada rekod diisi.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
