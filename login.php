<?php
session_start();  // Start session to track user login
include "db.php";  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email & password are entered
    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
        exit();
    }

    // Prepare SQL query to check user in the database
    $stmt = $conn->prepare("SELECT Email, Pass, Userrole FROM persons WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($table_email, $table_password, $table_role);
        $stmt->fetch();

        // Verify the password
        if ($password == $table_password) {
            $_SESSION['user_id'] = $table_email;  // Store user emai in session
            if ($table_role == 'STUDENT') {
                echo "success student";
            }
            if ($table_role == 'WARDEN') {
                echo "success warden";
            }
            if ($table_role == 'CHEIF_WARDEN') {
                echo "success cheif warden";
            }
            if ($table_role == 'SECURITY_INCHARGE') {
                echo "successsecurityincharge";
            }
            if ($table_role == 'REGISTRAR') {
                echo "success registrar";
            }
            if ($table_role == 'ACCOUNTS') {
                echo "successaccounts";
            }
            // Redirect user to dashboard.html
            
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>