<?php
function addNotification($conn, $message, $user_id = null) {
    if ($user_id === null) {
        $sql = "INSERT INTO notifications (message, user_id) VALUES (?, NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $message);
    } else {
        $sql = "INSERT INTO notifications (message, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $message, $user_id);
    }
    $stmt->execute();
    $stmt->close();
}
?>
