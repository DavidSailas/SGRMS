<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!isset($_GET['s_id']) || !filter_var($_GET['s_id'], FILTER_VALIDATE_INT)) {
    die("Invalid student ID.");
}

$s_id = intval($_GET['s_id']);

$sql = "SELECT * FROM students WHERE s_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $s_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Student not found.");
}

$row = $result->fetch_assoc();

// Close connections
$stmt->close();
$conn->close();

// Output student details
echo "<div class='info'><strong>Name:</strong> " . htmlspecialchars($row['lname'] . ", " . $row['fname'] . " " . $row['mname']) . "</div>";
echo "<div class='info'><strong>Date of Birth:</strong> " . htmlspecialchars($row['bod']) . "</div>";
echo "<div class='info'><strong>Age:</strong> " . (new DateTime($row['bod']))->diff(new DateTime())->y . "</div>";
echo "<div class='info'><strong>Educational Level:</strong> " . htmlspecialchars($row['educ_level']) . "</div>";
echo "<div class='info'><strong>Section:</strong> " . htmlspecialchars($row['section']) . "</div>";
?>
