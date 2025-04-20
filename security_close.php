<?php
include 'db.php';

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    $query = "UPDATE incident SET Status = 'Closed' WHERE IncidentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $incident_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating incident: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}