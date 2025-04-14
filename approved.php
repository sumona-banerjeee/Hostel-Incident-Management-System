<?php
include 'db.php'; // Ensure database connection

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    // Step 1: Fetch incident data including Rollno and Detail
    $incident_query = "SELECT Rollno, Detail FROM incident WHERE IncidentID = ?";
    $incident_stmt = $conn->prepare($incident_query);
    $incident_stmt->bind_param("i", $incident_id);
    $incident_stmt->execute();
    $incident_result = $incident_stmt->get_result();

    if ($incident_result->num_rows > 0) {
        $incident = $incident_result->fetch_assoc();
        $rollno = $incident['Rollno'];
        $incident_detail = $incident['Detail'];

        // Step 2: Fetch ParentEmail from persons table using Rollno
        $parent_query = "SELECT ParentEmail FROM persons WHERE Rollno = ?";
        $parent_stmt = $conn->prepare($parent_query);
        $parent_stmt->bind_param("s", $rollno);
        $parent_stmt->execute();
        $parent_result = $parent_stmt->get_result();

        if ($parent_result->num_rows > 0) {
            $parent = $parent_result->fetch_assoc();
            $to = $parent['ParentEmail'];

            $subject = "Incident Raised on your Ward";

            $message = "Hi Parents,\n\nThere is an incident raised on your ward's name, Please find the details below,\n\n";
            $message .= $incident_detail . "\n\n";
            $message .= "Please pay the fine on time.";

            $headers = "From: Incident <incident@hostelincidentmanagement.com>\r\n";
            $headers .= "Reply-To: incident@hostelincidentmanagement.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                // Update incident status to 'Active'
                $update_query = "UPDATE incident SET Status = 'Active' WHERE IncidentID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("i", $incident_id);

                if ($update_stmt->execute()) {
                    echo "success";
                } else {
                    echo "Error updating record: " . $conn->error;
                }

                $update_stmt->close();
            } else {
                echo "Failed to send email.";
            }

        } else {
            echo "Parent email not found for this roll number.";
        }

        $parent_stmt->close();
    } else {
        echo "Incident not found.";
    }

    $incident_stmt->close();
    $conn->close();
} else {
    echo "Invalid Request";
}
?>