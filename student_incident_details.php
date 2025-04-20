<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    $query = "SELECT i.IncidentID, i.FullName AS IncidentFullName, i.Rollno, i.Detail, i.Fine, i.WardenEmail, i.Status,
                     i.IncidentStatus, p.ParentsName
              FROM incident i
              LEFT JOIN persons p ON i.Rollno = p.Rollno
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
    <link rel="stylesheet" href="student_incident_details.css">
</head>
<body>
    <div class="container">
        <h4>Incident Details</h4>
        <table class="highlight">
            <tr><th>Incident ID</th><td><?php echo $incident['IncidentID']; ?></td></tr>
            <tr><th>Full Name</th><td><?php echo $incident['IncidentFullName']; ?></td></tr>
            <tr><th>Roll Number</th><td><?php echo $incident['Rollno']; ?></td></tr>
            <tr><th>Detail</th><td><?php echo $incident['Detail']; ?></td></tr>
            
            <?php if ($incident['IncidentStatus'] === 'Rusticated'): ?>
                <tr><th>Number of Days of Rustication</th><td><?php echo $incident['Fine']; ?></td></tr>
            <?php elseif ($incident['IncidentStatus'] === 'Outing Cancelled'): ?>
                <tr><th>Number of Days Outing Cancelled</th><td><?php echo $incident['Fine']; ?></td></tr>
            <?php else: ?>
                <tr><th>Fine</th><td><?php echo $incident['Fine']; ?></td></tr>
            <?php endif; ?>

            <tr><th>Incident Type</th><td><?php echo $incident['IncidentStatus']; ?></td></tr>
            <tr><th>Created by Warden Email</th><td><?php echo $incident['WardenEmail']; ?></td></tr>
            <tr><th>Status</th><td><?php echo $incident['Status']; ?></td></tr>
            <tr><th>Parents Name</th><td><?php echo $incident['ParentsName']; ?></td></tr>
        </table>

        <?php if ($incident['Status'] === 'Active' && $incident['IncidentStatus'] === 'Others'): ?>
            <button class="btn waves-effect waves-light" id="scheduleBtn">Schedule Payment</button>
            <p id="message" style="color: green; display: none;">Payment has been scheduled. Please visit account section in two days.</p>
        <?php endif; ?>

        <a href="studentdashboard.php" class="btn waves-effect waves-light">Back to Dashboard</a>
    </div>

    <script>
        const scheduleBtn = document.getElementById("scheduleBtn");
        if (scheduleBtn) {
            scheduleBtn.addEventListener("click", function() {
                var incidentId = <?php echo $incident['IncidentID']; ?>;
                
                fetch("schedule.php?id=" + incidentId, {
                    method: "GET"
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        document.getElementById("message").style.display = "block";
                        scheduleBtn.style.display = "none";
                    } else {
                        alert("Error: " + data);
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>