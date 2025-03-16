<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $grade_section = $_POST['grade_section'];
    $case_type = $_POST['case_type'];
    $description = $_POST['description'];
    $reported_by = $_POST['reported_by'];
    $status = "Pending";

    
    $filed_date = date("Y-m-d"); 
    $filed_time = date("H:i:s"); 

    $sql = "INSERT INTO case_records (student_name, grade_section, case_type, description, reported_by, filed_date, filed_time, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $student_name, $grade_section, $case_type, $description, $reported_by, $filed_date, $filed_time, $status);

<<<<<<< HEAD
    if ($stmt->execute()) {
=======
    if ($conn->query($update_sql) === TRUE) {
>>>>>>> 6b3068f81596d28b579c33b0538e5817a47f9b4e
        echo "Case added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Case</title>
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
            <label for="grade_section">Grade & Section:</label>
            <input type="text" id="grade_section" name="grade_section" required>
        </div>
        <div class="form-group">
            <label for="case_type">Case Type:</label>
            <input type="text" id="case_type" name="case_type" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="3" required></textarea>
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
