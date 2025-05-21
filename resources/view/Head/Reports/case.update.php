<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    
    // Fetch case details
    $sql = "SELECT * FROM case_records WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $case = $result->fetch_assoc();
    } else {
        echo "<script>alert('Case not found!'); window.location.href='case.php';</script>";
        exit;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = htmlspecialchars($_POST['student_name']);
    $academic_level = htmlspecialchars($_POST['academic_level']);
    $course_section = htmlspecialchars($_POST['course_section']);
    $case_type = htmlspecialchars($_POST['case_type']);
    $description = htmlspecialchars($_POST['description']);
    $reported_by = htmlspecialchars($_POST['reported_by']);
    $referred_by = htmlspecialchars($_POST['referred_by']);
    $referral_date = htmlspecialchars($_POST['referral_date']);
    $reason_for_referral = htmlspecialchars($_POST['reason_for_referral']);
    $presenting_problem = htmlspecialchars($_POST['presenting_problem']);
    $observe_behavior = htmlspecialchars($_POST['observe_behavior']);
   
    $counselor_assessment = htmlspecialchars($_POST['counselor_assessment']);
    $recommendations = htmlspecialchars($_POST['recommendations']);
    $follow_up_plan = htmlspecialchars($_POST['follow_up_plan']);
    $status = htmlspecialchars($_POST['status']);

    $update_sql = "UPDATE case_records 
                   SET student_name = ?, academic_level = ?, course_section = ?, case_type = ?, description = ?, 
                       reported_by = ?, referred_by = ?, referral_date = ?, reason_for_referral = ?, 
                       presenting_problem = ?, observe_behavior = ?, counselor_assessment = ?, 
                       recommendations = ?, follow_up_plan = ?, status = ? 
                   WHERE case_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param(
        "sssssssssssssssi", 
        $student_name, $academic_level, $course_section, $case_type, $description, $reported_by, 
        $referred_by, $referral_date, $reason_for_referral, $presenting_problem, $observe_behavior,
        $counselor_assessment, $recommendations, $follow_up_plan, $status, $case_id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Case updated successfully!'); window.location.href='case.php';</script>";
    } else {
        echo "Error updating case: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Case</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 120px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        #course_section_group {
            display: none;
        }
    </style>
    <script>
        function toggleCourseInput() {
            var academicLevel = document.getElementById("academic_level").value;
            var courseSectionGroup = document.getElementById("course_section_group");

            if (academicLevel !== "") { // Show for all levels
                courseSectionGroup.style.display = "block";
            } else {
                courseSectionGroup.style.display = "none";
                document.getElementById("course_section").value = ""; // Clear input when hidden
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Edit Case</h2>
    <form method="POST">
        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" value="<?= htmlspecialchars($case['student_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="academic_level">Academic Level:</label>
            <select id="academic_level" name="academic_level" required onchange="toggleCourseInput()">
                <option value="Elementary" <?= $case['academic_level'] == 'Elementary' ? 'selected' : '' ?>>Elementary</option>
                <option value="High School" <?= $case['academic_level'] == 'High School' ? 'selected' : '' ?>>High School</option>
                <option value="College" <?= $case['academic_level'] == 'College' ? 'selected' : '' ?>>College</option>
            </select>
        </div>
        <div class="form-group" id="course_section_group" style="display: <?= !empty($case['course_section']) ? 'block' : 'none' ?>;">
            <label for="course_section">Course/Section:</label>
            <input type="text" id="course_section" name="course_section" value="<?= htmlspecialchars($case['course_section']) ?>">
        </div>
        <div class="form-group">
            <label for="case_type">Case Type:</label>
            <input type="text" id="case_type" name="case_type" value="<?= htmlspecialchars($case['case_type']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($case['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="reported_by">Reported By:</label>
            <input type="text" id="reported_by" name="reported_by" value="<?= htmlspecialchars($case['reported_by']) ?>" required>
        </div>
        <div class="form-group">
            <label for="referred_by">Referred By:</label>
            <input type="text" id="referred_by" name="referred_by" value="<?= htmlspecialchars($case['referred_by']) ?>" required>
        </div>
        <div class="form-group">
            <label for="referral_date">Referral Date:</label>
            <input type="date" id="referral_date" name="referral_date" value="<?= htmlspecialchars($case['referral_date']) ?>" required>
        </div>
        <div class="form-group">
            <label for="reason_for_referral">Reason for Referral:</label>
            <input type="text" id="reason_for_referral" name="reason_for_referral" value="<?= htmlspecialchars($case['reason_for_referral']) ?>" required>
        </div>
        <div class="form-group">
            <label for="presenting_problem">Presenting Problem:</label>
            <input type="text" id="presenting_problem" name="presenting_problem" value="<?= htmlspecialchars($case['presenting_problem']) ?>" required>
        </div>
        <div class="form-group">
            <label for="observe_behavior">Observed Behavior:</label>
            <textarea id="observe_behavior" name="observe_behavior" required><?= htmlspecialchars($case['observe_behavior']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="counselor_assessment">Counselor Assessment:</label>
            <textarea id="counselor_assessment" name="counselor_assessment" required><?= htmlspecialchars($case['counselor_assessment']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="recommendations">Recommendations:</label>
            <textarea id="recommendations" name="recommendations" required><?= htmlspecialchars($case['recommendations']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="follow_up_plan">Follow-Up Plan:</label>
            <textarea id="follow_up_plan" name="follow_up_plan" required><?= htmlspecialchars($case['follow_up_plan']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending" <?= $case['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $case['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Resolved" <?= $case['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>
        </div>
        <button type="submit">Update Case</button>
    </form>
    <a href="case.php">Back to Home</a>
</div>
</body>
</html>
