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

// Check if record ID is provided
if (isset($_POST['record_id'])) {
    $record_id = $_POST['record_id'];

    // SQL to delete the record
    $sql = "DELETE FROM records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Redirect back to view_records.php with a success message
        header("Location: warden_records.php?message=Record deleted successfully");
    } else {
        // Redirect back to view_records.php with an error message
        header("Location: warden_records.php?message=Failed to delete record");
    }

    $stmt->close();
} else {
    header("Location: warden_records.php?message=No record ID provided");
}

$conn->close();
?>
