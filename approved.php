<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $incident_id = $_GET['id'];
    $incident_type = $_GET['type'];

    // If Rusticated, set status to Pending Registrar Approval and notify registrar
    if ($incident_type === "Rusticated") {
        // Update status
        $update_query = "UPDATE incident SET Status = 'Pending Registrar Approval' WHERE IncidentID = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $incident_id);

        if ($stmt->execute()) {
            // Fetch incident details
            $incident_query = "SELECT Rollno, Detail FROM incident WHERE IncidentID = ?";
            $incident_stmt = $conn->prepare($incident_query);
            $incident_stmt->bind_param("i", $incident_id);
            $incident_stmt->execute();
            $incident_result = $incident_stmt->get_result();

            if ($incident_result->num_rows > 0) {
                $incident = $incident_result->fetch_assoc();
                $rollno = $incident['Rollno'];
                $incident_detail = $incident['Detail'];

                // Fetch registrar email
                $registrar_query = "SELECT Email FROM persons WHERE UserRole = 'REGISTRAR' LIMIT 1";
                $registrar_result = $conn->query($registrar_query);

                if ($registrar_result->num_rows > 0) {
                    $registrar = $registrar_result->fetch_assoc();
                    $to = $registrar['Email'];

                    $subject = "Rustication Request for Approval";

                    $message = "Dear Registrar,\n\nA student has been marked for rustication.\n\n";
                    $message .= "Roll No: $rollno\nDetails: $incident_detail\n\n";
                    $message .= "Please review and approve this request from your portal.\n\nThank you.";

                    $headers = "From: Incident <incident@hostelincidentmanagement.com>\r\n";
                    $headers .= "Reply-To: incident@hostelincidentmanagement.com\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                    if (mail($to, $subject, $message, $headers)) {
                        echo "success";
                    } else {
                        echo "Status updated, but failed to notify registrar.";
                    }
                } else {
                    echo "Status updated, but registrar email not found.";
                }
            } else {
                echo "Incident found, but failed to retrieve details.";
            }
        } else {
            echo "Error updating status.";
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    // For Others / Outing Cancelled - Email to parent and activate
    $incident_query = "SELECT Rollno, Detail FROM incident WHERE IncidentID = ?";
    $incident_stmt = $conn->prepare($incident_query);
    $incident_stmt->bind_param("i", $incident_id);
    $incident_stmt->execute();
    $incident_result = $incident_stmt->get_result();

    if ($incident_result->num_rows > 0) {
        $incident = $incident_result->fetch_assoc();
        $rollno = $incident['Rollno'];
        $incident_detail = $incident['Detail'];

        // Parent email
        $parent_query = "SELECT ParentEmail FROM persons WHERE Rollno = ?";
        $parent_stmt = $conn->prepare($parent_query);
        $parent_stmt->bind_param("s", $rollno);
        $parent_stmt->execute();
        $parent_result = $parent_stmt->get_result();

        if ($parent_result->num_rows > 0) {
            $parent = $parent_result->fetch_assoc();
            $to = $parent['ParentEmail'];

            $subject = "Incident Raised on your Ward";

            $message = "Hi Parents,\n\nAn incident has been raised for your ward.\n\n";
            $message .= "Incident Details:\n" . $incident_detail . "\n\n";
            $message .= "Please ensure the fine or necessary steps are followed as per hostel policy.\n\nThank you.";

            $headers = "From: Incident <incident@hostelincidentmanagement.com>\r\n";
            $headers .= "Reply-To: incident@hostelincidentmanagement.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                // Update status
                $update_query = "UPDATE incident SET Status = 'Active' WHERE IncidentID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("i", $incident_id);

                if ($update_stmt->execute()) {
                    echo "success";
                } else {
                    echo "Error updating status.";
                }

                $update_stmt->close();
            } else {
                echo "Failed to send email.";
            }

        } else {
            echo "Parent email not found.";
        }

        $parent_stmt->close();
    } else {
        echo "Incident not found.";
    }

    $incident_stmt->close();
    $conn->close();
} else {
    echo "Invalid Request.";
}
?>