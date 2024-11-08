<?php
// Establish database connection
$conn = new mysqli("localhost", "root", "", "keluarmasuk");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example query to fetch records
$sql = "SELECT id, register_number, reason, other_details, request_date, status FROM records"; // Adjust table name if needed
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error); // Handle query error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Records</title>

    <style>
        /* General styles for the page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 30px;
            margin-right: 80px;
        }

        /* Table container */
        .table-container {
            margin: 0 auto;
            max-width: 1200px;
            overflow-x: auto;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            font-size: 1rem;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #eaeaea;
        }

        /* Links inside the table */
        td a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }

        td a:hover {
            color: #2c3e50;
        }

        /* Button styling */
        button {
            padding: 10px 15px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin: 0 5px 10px;
        }

        button[name="action"][value="accept"] {
            background-color: #2ecc71;
            color: white;
        }

        button[name="action"][value="accept"]:hover {
            background-color: #27ae60;
            transform: translateY(-1px); /* Lift effect on hover */
        }

        button[name="action"][value="reject"] {
            background-color: #e74c3c;
            color: white;
        }

        button[name="action"][value="reject"]:hover {
            background-color: #c0392b;
            transform: translateY(-1px); /* Lift effect on hover */
        }

        .btn-back {
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
            width: 6.8%;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #e86969;
            color: white;
        }

        .btn-delete:hover {
            background-color: #ea2020;
        }

        /* Status classes */
        .status-accepted {
            background-color: #2ecc71; /* Green for accepted */
            color: white;
        }

        .status-rejected {
            background-color: #e74c3c; /* Red for rejected */
            color: white;
        }

        .status-pending {
            background-color: #f1c40f; /* Yellow for pending */
            color: white; /* Use black text for contrast */
        }
    </style>
</head>
<body>
    <a href="indexwarden.php"><button class="btn-back">Kembali</button></a>
    <h2>Rekod Pelajar</h2>

    <div class="table-container">
        <table>
            <tr>
                <th>Nombor Daftar</th>
                <th>Urusan Keluar</th>
                <th>Tarikh Mohon</th>
                <th>Status</th>
                <th>Butiran</th>
                <th>Tindakan</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['register_number']); ?></td>
                        <td>
                            <?php 
                                // Show "Lain-lain" details if applicable
                                if ($row['reason'] == 'Lain-lain') {
                                    echo 'Lain-lain (' . htmlspecialchars($row['other_details']) . ')';
                                } else {
                                    echo htmlspecialchars($row['reason']);
                                }
                            ?>
                        </td>
                        <td><?php echo date("Y-m-d", strtotime($row['request_date'])); ?></td>
                        <td class="<?php 
                            if ($row['status'] == 'accepted') {
                                echo 'status-accepted'; 
                            } elseif ($row['status'] == 'rejected') {
                                echo 'status-rejected'; 
                            } elseif ($row['status'] == 'pending') {
                                echo 'status-pending'; 
                            } 
                        ?>">
                            <?php 
                            if ($row['status'] == 'accepted') {
                                echo 'Diterima'; 
                            } elseif ($row['status'] == 'rejected') {
                                echo 'Ditolak'; 
                            } elseif ($row['status'] == 'pending') {
                                echo 'Menunggu'; 
                            } else {
                                echo ucfirst($row['status']); 
                            }
                            ?>
                        </td>
                        <td><a href="student_details.php?id=<?php echo $row['id']; ?>">Butiran</a></td>
                        <td>
                            <form action="update_status.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="record_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="accept">Terima</button>
                                <button type="submit" name="action" value="reject">Tolak</button>
                            </form>
                            <form action="delete_record.php" method="POST" style="display: inline-block;" onsubmit="return confirm('Adakah anda pasti mahu memadamkan rekod ini?');">
                                <input type="hidden" name="record_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn-delete">Padam</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="message">Tiada rekod dijumpai.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

</body>
</html>

<?php $conn->close(); ?> <!-- Don't forget to close the database connection -->
