<?php

include '../../../database/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Mark the notification as read
    $conn->query("UPDATE notifications SET is_read = 1 WHERE id = $id");

    // Get notification details
    $notifResult = $conn->query("SELECT * FROM notifications WHERE id = $id");
    if ($notifResult && $notif = $notifResult->fetch_assoc()) {
        echo "<h2>Notification Details</h2>";
        echo "<div style='margin-bottom:10px;'><strong>Message:</strong><br>" . htmlspecialchars($notif['message']) . "</div>";
        echo "<div><strong>Date:</strong> " . date('M d, Y H:i', strtotime($notif['timestamp'])) . "</div>";

        // If notification is linked to a case, show case details
        if (!empty($notif['case_id'])) {
            $caseId = intval($notif['case_id']);
            $caseResult = $conn->query("SELECT * FROM case_records WHERE case_id = $caseId");
            if ($caseResult && $case = $caseResult->fetch_assoc()) {
                echo "<hr><h3>Case Details</h3>";
                echo "<div><strong>Case ID:</strong> " . htmlspecialchars($case['case_id']) . "</div>";
                echo "<div><strong>Type:</strong> " . htmlspecialchars($case['case_type']) . "</div>";
                echo "<div><strong>Status:</strong> " . htmlspecialchars($case['status']) . "</div>";
                echo "<div><strong>Filed Date:</strong> " . htmlspecialchars($case['filed_date']) . "</div>";
                echo "<div><strong>Description:</strong> " . nl2br(htmlspecialchars($case['description'])) . "</div>";
                // Add more fields as needed
            }
        }
    } else {
        echo "<div>Notification not found.</div>";
    }
} else {
    echo "<div>No notification selected.</div>";
}
?>