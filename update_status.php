<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $record_id = $_POST['record_id'];
    $action = $_POST['action'];
    $status = ($action == 'accept') ? 'accepted' : 'rejected';

    $sql = "UPDATE records SET status='$status' WHERE id='$record_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: warden_records.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
