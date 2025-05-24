<?php
include '../../../../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $case_id = intval($_POST['case_id']); 
    $sql = "UPDATE case_records SET
        case_type = ?, description = ?, reported_by = ?, referred_by = ?, referral_date = ?,
        reason_for_referral = ?, presenting_problem = ?, observe_behavior = ?, family_background = ?,
        academic_history = ?, social_relationships = ?, medical_history = ?, counselor_assessment = ?,
        recommendations = ?, follow_up_plan = ?, status = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssi",
        $_POST['case_type'], $_POST['description'], $_POST['reported_by'], $_POST['referred_by'],
        $_POST['referral_date'], $_POST['reason_for_referral'], $_POST['presenting_problem'],
        $_POST['observe_behavior'], $_POST['family_background'], $_POST['academic_history'],
        $_POST['social_relationships'], $_POST['medical_history'], $_POST['counselor_assessment'],
        $_POST['recommendations'], $_POST['follow_up_plan'], $_POST['status'], $case_id
    );

    if ($stmt->execute()) {
        header("Location: ../../../../resources/view/Head/case.php?case=updated");
        exit();
    } else {
        echo "<script>alert('Update failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
