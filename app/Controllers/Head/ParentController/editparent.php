<?php
session_start();
include '../../../../database/db_connect.php';

// Read POST data
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$relationship = $_POST['relationship'] ?? null;
$contact = $_POST['contact'] ?? null;
$email = $_POST['email'] ?? null;
$username = $_POST['username'] ?? null;

if (!$id || !$name || !$relationship || !$contact || !$email) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Start transaction to update both tables
$conn->begin_transaction();

try {
    // Update parents table
    $stmt = $conn->prepare("UPDATE parents SET guardian_name=?, relationship=?, contact_num=?, email=? WHERE p_id=?");
    $stmt->bind_param("ssssi", $name, $relationship, $contact, $email, $id);
    $stmt->execute();

    // Update users table if username is given (or update email in users if needed)
    // Assumes users table has unique username and that parent_id links users to parents
    if (!empty($username)) {
        $stmtUser = $conn->prepare("UPDATE users SET username=?, email=? WHERE parent_id=? AND role='Parent'");
        $stmtUser->bind_param("ssi", $username, $email, $id);
        $stmtUser->execute();
    } else {
        // If username empty, only update email in users if account exists
        $stmtUser = $conn->prepare("UPDATE users SET email=? WHERE parent_id=? AND role='Parent'");
        $stmtUser->bind_param("si", $email, $id);
        $stmtUser->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
