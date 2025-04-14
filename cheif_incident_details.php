<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
exit();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
exit();
}

include 'db.php'; // Ensure this connects to your database

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    // Fetch incident details and related person data using a JOIN
    $query = "SELECT i.IncidentID, i.FullName AS IncidentFullName, i.Rollno, i.Detail, i.Fine, i.WardenEmail, i.Status,
                     p.ParentsName
              FROM incident i
              LEFT JOIN persons p ON i.Rollno= p.Rollno
              WHERE i.IncidentID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $incident_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $incident = $result->fetch_assoc();
    } else {
        echo "Incident not found.";
        exit;
    }
} else {
    echo "Invalid Request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cheif_incident_details.css">
</head>
<body>
    <div class="container">
        <h4>Incident Details</h4>
        <table class="highlight">
            <tr><th>Incident ID</th><td><?php echo $incident['IncidentID']; ?></td></tr>
            <tr><th>Full Name</th><td><?php echo $incident['IncidentFullName']; ?></td></tr>
            <tr><th>Roll Number</th><td><?php echo $incident['Rollno']; ?></td></tr>
            <tr><th>Detail</th><td><?php echo $incident['Detail']; ?></td></tr>
            <tr><th>Fine</th><td><?php echo $incident['Fine']; ?></td></tr>
            <tr><th>Created by Warden Email</th><td><?php echo $incident['WardenEmail']; ?></td></tr>
            <tr><th>Status</th><td><?php echo $incident['Status']; ?></td></tr>
            <tr><th>Parents Name</th><td><?php echo $incident['ParentsName']; ?></td></tr>
        </table>

        <?php if ($incident['Status'] === 'New'): ?>
            <button class="btn waves-effect waves-light" id="approveBtn">Approve Incident</button>
            <p id="message" style="color: green; display: none;">The incident is in force</p>
            <?php endif;?>

        <a href="cheifwardendashboard.php" class="btn waves-effect waves-light">Back to Dashboard</a>
    </div>

<script>
    document.getElementById("approveBtn").addEventListener("click", function() {
        var incidentId = <?php echo $incident['IncidentID']; ?>;
        
        fetch("approved.php?id=" + incidentId, {
            method: "GET"
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                document.getElementById("message").style.display = "block";
                document.getElementById("approveBtn").style.display = "none";
            } else {
                alert("Error: " + data);
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
