<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $rollNo = $_POST['rollNo'];
    $detail = $_POST['detail'];
    $incidentType = $_POST['incidentType'];
    $fine = ($incidentType == 'Others') ? $_POST['fine'] : $_POST['days'];
    $wardenEmail = $_SESSION['user_id'];

    // Insert incident into database
    $query = "INSERT INTO incident (FullName, Rollno, Detail, Fine, WardenEmail, Status, IncidentStatus) 
              VALUES (?, ?, ?, ?, ?, 'New', ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiss", $fullName, $rollNo, $detail, $fine, $wardenEmail, $incidentType);

    $query1 = "SELECT Userrole FROM persons WHERE Email = '" . $_SESSION['user_id'] . "'";
    $result1 = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result1);

    if ($stmt->execute()) {
        if ($row['Userrole'] == 'CHEIF_WARDEN') {
            echo "<script>alert('Incident Created Successfully!'); window.location.href='cheifwardendashboard.php';</script>";
        } else {
            echo "<script>alert('Incident Created Successfully!'); window.location.href='wardendashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Error Creating Incident. Try Again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Incident</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="create_incident.css">
</head>
<body>
    <div class="container">
        <h4>Create New Incident</h4>
        <form method="POST">
            <div class="input-field">
                <input type="text" name="fullName" required>
                <label>Full Name</label>
            </div>

            <div class="input-field">
                <input type="text" name="rollNo" required>
                <label>Roll Number</label>
            </div>

            <div class="input-field">
                <textarea name="detail" class="materialize-textarea" required></textarea>
                <label>Incident Details</label>
            </div>

            <div class="input-field">
                <select id="incidentType" name="incidentType" required>
                    <option value="" disabled selected>Choose Incident Type</option>
                    <option value="Others">Others</option>
                    <option value="Rusticated">Rusticated</option>
                    <option value="Outing Cancelled">Outing Cancelled</option>
                </select>
                <label>Incident Type</label>
            </div>

            <div class="input-field" id="fineField">
                <input type="number" name="fine" id="fineInput">
                <label for="fineInput">Fine Amount (₹)</label>
            </div>

            <div class="input-field" id="daysField" style="display: none;">
                <input type="number" name="days" id="daysInput">
                <label for="daysInput">Number of Days</label>
            </div>

            <button type="submit" class="btn waves-effect waves-light">Submit</button>
            <a href="wardendashboard.php" class="btn grey">Cancel</a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);

            const incidentType = document.getElementById('incidentType');
            const fineField = document.getElementById('fineField');
            const daysField = document.getElementById('daysField');
            const fineInput = document.getElementById('fineInput');
            const daysInput = document.getElementById('daysInput');

            incidentType.addEventListener('change', function () {
                if (this.value === 'Others') {
                    fineField.style.display = 'block';
                    daysField.style.display = 'none';
                    fineInput.required = true;
                    daysInput.required = false;
                    daysInput.value = '';
                } else {
                    fineField.style.display = 'none';
                    daysField.style.display = 'block';
                    fineInput.required = false;
                    daysInput.required = true;
                    fineInput.value = '';
                }
            });
        });
    </script>
</body>
</html>