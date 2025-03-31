<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $academic_level = $_POST['academic_level'];
    $course_section = $_POST['course_section']; // Always store course_section
    $case_type = $_POST['case_type'];
    $description = $_POST['description'];
    $reported_by = $_POST['reported_by'];
    $status = "Pending";

    $filed_date = date("Y-m-d"); 
    $filed_time = date("H:i:s"); 

    // Insert case record
    $sql = "INSERT INTO case_records (student_name, academic_level, course_section, case_type, description, reported_by, filed_date, filed_time, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $student_name, $academic_level, $course_section, $case_type, $description, $reported_by, $filed_date, $filed_time, $status);
        
        if ($stmt->execute()) {
            echo "<script>alert('Case added successfully!'); window.location.href='case.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Case</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
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
    <h2>Add New Case</h2>
    <form action="add.case.php" method="POST">
        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>
        </div>
        <div class="form-group">
            <label for="academic_level">Academic Level:</label>
            <select id="academic_level" name="academic_level" required onchange="toggleCourseInput()">
                <option value="">Select Academic Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>
        </div>
        <div class="form-group" id="course_section_group">
            <label for="course_section">Course/Section:</label>
            <input type="text" id="course_section" name="course_section">
        </div>
        <div class="form-group">
            <label for="case_type">Case Type:</label>
            <input type="text" id="case_type" name="case_type" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="reported_by">Reported By:</label>
            <input type="text" id="reported_by" name="reported_by" required>
        </div>
        <button type="submit">Submit</button>
    </form>
    <a href="case.php">Back to Home</a>
</div>

</body>
</html>
