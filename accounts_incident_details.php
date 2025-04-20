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
                     p.ParentsName
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
    <link rel="stylesheet" href="registerar_incident_details.css">
    <style>
        .button-row {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
    </style>
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
            <tr><th>Status</th><td id="incidentStatus"><?php echo $incident['Status']; ?></td></tr>
            <tr><th>Parents Name</th><td><?php echo $incident['ParentsName']; ?></td></tr>
        </table>

        <div class="button-row">
            <a href="accountsdashboard.php" class="btn waves-effect waves-light">Back to Dashboard</a>

            <?php if ($incident['Status'] !== 'Closed'): ?>
                <button class="btn red darken-1" id="closeIncidentBtn">Close</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.getElementById("closeIncidentBtn")?.addEventListener("click", function () {
            if (confirm("Are you sure you want to close this incident?")) {
                const id = <?php echo $incident['IncidentID']; ?>;

                fetch("security_close.php?id=" + id)
                    .then(res => res.text())
                    .then(data => {
                        if (data.trim() === "success") {
                            document.getElementById("incidentStatus").innerText = "Closed";
                            document.getElementById("closeIncidentBtn").style.display = "none";
                        } else {
                            alert("Error: " + data);
                        }
                    })
                    .catch(err => alert("Request failed: " + err));
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>