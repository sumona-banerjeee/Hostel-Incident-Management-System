<?php
include 'db.php'; // Ensure database connection

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    $query = "UPDATE incident SET Status = 'Scheduled for Payment' WHERE IncidentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $incident_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request";
}
?>
