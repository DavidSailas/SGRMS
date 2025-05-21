<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    $updateSql = "UPDATE case_records SET status = 'Active' WHERE case_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    echo "<script>alert('Case approved successfully!'); window.location.href='case.php';</script>";
    $stmt->close();
}

$conn->close();
?>
