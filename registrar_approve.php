<?php
include 'db.php';

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    // Fetch incident details
    $incident_query = "SELECT Rollno, Detail, Fine FROM incident WHERE IncidentID = ?";
    $stmt = $conn->prepare($incident_query);
    $stmt->bind_param("i", $incident_id);
    $stmt->execute();
    $incident_result = $stmt->get_result();

    if ($incident_result->num_rows > 0) {
        $incident = $incident_result->fetch_assoc();
        $rollno = $incident['Rollno'];
        $reason = $incident['Detail'];
        $days = $incident['Fine']; // Fine used as number of rustication days

        // Fetch parent's email
        $parent_query = "SELECT ParentEmail FROM persons WHERE Rollno = ?";
        $parent_stmt = $conn->prepare($parent_query);
        $parent_stmt->bind_param("s", $rollno);
        $parent_stmt->execute();
        $parent_result = $parent_stmt->get_result();

        if ($parent_result->num_rows > 0) {
            $parent = $parent_result->fetch_assoc();
            $to = $parent['ParentEmail'];
            $subject = "Rustication Notice for Your Ward";

            $message = "Dear Parent,\n\n";
            $message .= "Your ward has been rusticated for {$days} day(s).\n";
            $message .= "Reason: {$reason}\n\n";
            $message .= "Please contact the hostel administration for further details.\n\n";
            $message .= "Regards,\nHostel Management";

            $headers = "From: Hostel Incident <incident@hostelincidentmanagement.com>\r\n";
            $headers .= "Reply-To: incident@hostelincidentmanagement.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Send email and update status
            if (mail($to, $subject, $message, $headers)) {
                $update_query = "UPDATE incident SET Status = 'Active' WHERE IncidentID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("i", $incident_id);
                if ($update_stmt->execute()) {
                    echo "success";
                } else {
                    echo "Error updating incident status.";
                }
                $update_stmt->close();
            } else {
                echo "Email sending failed.";
            }
        } else {
            echo "Parent email not found.";
        }

        $parent_stmt->close();
    } else {
        echo "Incident not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request.";
}