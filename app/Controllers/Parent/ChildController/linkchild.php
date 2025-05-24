<?php
session_start();
include '../../../../database/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parent_id = $_POST['parent_id'] ?? null;
    $id_num = trim($_POST['sccnumber'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $relationship = $_POST['relationship'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!$parent_id || !$id_num || !$lname || !$fname || !$relationship) {
        die("Missing required fields.");
    }

    try {
        // Prepare SQL to find the student
        $stmt = $pdo->prepare("SELECT s_id, parent_id FROM students WHERE id_num = ? ");
        $stmt->execute([$id_num]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            if ($student['parent_id']) {
                die("This student is already linked to a parent.");
            }

            // Update the student to link with parent
            $update = $pdo->prepare("UPDATE students SET parent_id = ? WHERE s_id = ?");
            $update->execute([$parent_id, $student['s_id']]);


            echo "Child linked successfully.";
        } else {
            echo "Student not found.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Invalid request.";
}
