<?php
include 'db.php'; // Make sure this file correctly connects to your database
//session_start();
//$query = "SELECT IncidentID, Rollno, Status FROM incident WHERE $_SESSION['user_id'] = WardenEmail";

$query = "SELECT IncidentID, Rollno, Status FROM incident WHERE WardenEmail = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td><a href='incident_details.php?id={$row['IncidentID']}'>{$row['IncidentID']}</a></td>
                <td>{$row['Rollno']}</td>
                <td>{$row['Status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No incidents found</td></tr>";
}

mysqli_close($conn);
?>