<?php
include 'db.php'; // Make sure this file correctly connects to your database
//session_start();

//$query = "SELECT IncidentID.incident, Rollno.incident, Status FROM incident, persons WHERE ";
$query = "SELECT incident.IncidentID, incident.Rollno, incident.Status
FROM incident
INNER JOIN persons ON incident.Rollno = persons.Rollno
WHERE incident.Status != 'New' AND persons.Email = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td><a href='student_incident_details.php?id={$row['IncidentID']}'>{$row['IncidentID']}</a></td>
                <td>{$row['Rollno']}</td>
                <td>{$row['Status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No incidents found</td></tr>";
}

mysqli_close($conn);
?>