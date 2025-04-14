<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
exit();
}
?>
<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="wardendashboard.css">
</head>
<body>
    <div class="container">
        <h4>Welcome, <span id="wardenName">Warden</span></h4>
        <h5>Warden Dashboard</h5><a href="create_incident.php" class="btn waves-effect waves-light">Create New Incident</a>
        <a href="logout.php" class="btn waves-effect waves-light" id="logout">Log Out</a>
    
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Incident ID</th>
                <th>Roll Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="incidentTable">
            <?php include 'fetch_wardendashboard_incident.php'; ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>