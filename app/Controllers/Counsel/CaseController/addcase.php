<?php
include '../../../../database/db_connect.php';
require_once __DIR__ . '/../NotifyController/notify.php';
require_once __DIR__ . '/../NotifyController/notif_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : '';

    // Check if student_id is provided and exists in the database
    if (empty($student_id)) {
        echo "<script>alert('Error: No student selected.'); window.history.back();</script>";
        exit();
    }

    $studCheck = $conn->prepare("SELECT s_id, lname, fname, id_num FROM students WHERE s_id = ? AND status = 'active'");
    $studCheck->bind_param("i", $student_id);
    $studCheck->execute();
    $studCheck->store_result();

    if ($studCheck->num_rows === 0) {
        echo "<script>alert('Error: Student not found or not active.'); window.history.back();</script>";
        $studCheck->close();
        exit();
    }
    $studCheck->bind_result($s_id, $lname, $fname, $id_num);
    $studCheck->fetch();
    $studCheck->close();

    $case_type = $_POST['case_type'];
    $description = $_POST['description'];
    $reported_by = $_POST['reported_by'];
    $referred_by = $_POST['referred_by'];
    $referral_date = $_POST['referral_date'];
    $reason_for_referral = $_POST['reason_for_referral'];
    $presenting_problem = $_POST['presenting_problem'];
    $observe_behavior = $_POST['observe_behavior'];
    $family_background = $_POST['family_background'];
    $academic_history = $_POST['academic_history'];
    $social_relationships = $_POST['social_relationships'];
    $medical_history = $_POST['medical_history'];
    $counselor_assessment = $_POST['counselor_assessment'];
    $recommendations = $_POST['recommendations'];
    $follow_up_plan = $_POST['follow_up_plan'];
    $status = $_POST['status'];
    $filed_date = date("Y-m-d");
    $filed_time = date("H:i:s");

    $sql = "INSERT INTO case_records (
        student_id, case_type, description, reported_by, referred_by, referral_date,
        reason_for_referral, presenting_problem, observe_behavior, family_background,
        academic_history, social_relationships, medical_history, counselor_assessment,
        recommendations, follow_up_plan, filed_date, filed_time, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "issssssssssssssssss",
            $student_id, $case_type, $description, $reported_by, $referred_by, $referral_date,
            $reason_for_referral, $presenting_problem, $observe_behavior, $family_background,
            $academic_history, $social_relationships, $medical_history, $counselor_assessment,
            $recommendations, $follow_up_plan, $filed_date, $filed_time, $status
        );

        if ($stmt->execute()) {
            // Fetch student name and id_num for a professional notification
            $studRes = $conn->prepare("SELECT lname, fname, id_num FROM students WHERE s_id = ?");
            $studRes->bind_param("i", $student_id);
            $studRes->execute();
            $studRes->bind_result($lname, $fname, $id_num);
            $studRes->fetch();
            $studRes->close();

            // Use the improved notification helper
            $message = formatNotification('case_filed', [
                'case_type' => $case_type,
                'lname' => $lname,
                'fname' => $fname,
                'id_num' => $id_num
            ]);
            addNotification($conn, $message);

            header("Location: ../../../../resources/view/Head/case.php?new_case=added");
            exit();
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>
