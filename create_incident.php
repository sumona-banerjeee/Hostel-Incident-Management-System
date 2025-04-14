<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
exit();
} 

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $rollNo = $_POST['rollNo'];
    $detail = $_POST['detail'];
    $fine = $_POST['fine'];
    $wardenEmail = $_SESSION['user_id']; // Logged-in warden's email

    // Insert incident into database
    $query = "INSERT INTO incident (FullName, Rollno, Detail, Fine, WardenEmail, Status) 
              VALUES (?, ?, ?, ?, ?, 'New')";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssis", $fullName, $rollNo, $detail, $fine, $wardenEmail);

    $query1 = "SELECT Userrole FROM persons WHERE Email = '" . $_SESSION['user_id'] . "'";
    $result1 = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result1);

    if ($stmt->execute()) {
        if ($row['Userrole'] == 'CHEIF_WARDEN'){
            echo "<script>alert('Incident Created Successfully!'); window.location.href='cheifwardendashboard.php';</script>";
        }
        else {
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
                <input type="number" name="fine" required>
                <label>Fine Amount (₹)</label>
            </div>

            <button type="submit" class="btn waves-effect waves-light">Submit</button>
            <a href="wardendashboard.php" class="btn grey">Cancel</a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>