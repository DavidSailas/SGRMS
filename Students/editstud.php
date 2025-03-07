<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid student ID.");
}

$s_id = intval($_GET['id']);
$sql = "SELECT * FROM students WHERE s_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $s_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = trim($_POST['lname']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $bod = $_POST['bod'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $mobile_num = trim($_POST['mobile_num']);
    $email = trim($_POST['email']);
    $educ_level = $_POST['educ_level'];
    $year_level = $_POST['year_level'];
    $section = trim($_POST['section']);

    // Validate Required Fields
    if (empty($lname) || empty($fname) || empty($bod) || empty($gender) || empty($address) ||
        empty($mobile_num) || empty($email) || empty($educ_level) || empty($year_level) || empty($section)) {
        die("All fields are required.");
    }

    // Update student record
    $sql = "UPDATE students SET lname=?, fname=?, mname=?, bod=?, gender=?, address=?, mobile_num=?, email=?, educ_level=?, year_level=?, section=? WHERE s_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $lname, $fname, $mname, $bod, $gender, $address, $mobile_num, $email, $educ_level, $year_level, $section, $student_id);

    if ($stmt->execute()) {
        echo "Student updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="editstud.php?s_id=<?php echo $student_id; ?>" method="POST">
        <label>Last Name:</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($student['lname']); ?>" required>

        <label>First Name:</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($student['fname']); ?>" required>

        <label>Middle Name:</label>
        <input type="text" name="mname" value="<?php echo htmlspecialchars($student['mname']); ?>">

        <label>Date of Birth:</label>
        <input type="date" name="bod" value="<?php echo htmlspecialchars($student['bod']); ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($student['address']); ?>" required>

        <label>Phone Number:</label>
        <input type="text" name="mobile_num" value="<?php echo htmlspecialchars($student['mobile_num']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

        <label>Educational Level:</label>
        <select name="educ_level" required>
            <option value="Elementary" <?php echo ($student['educ_level'] == 'Elementary') ? 'selected' : ''; ?>>Elementary</option>
            <option value="High School" <?php echo ($student['educ_level'] == 'High School') ? 'selected' : ''; ?>>High School</option>
            <option value="College" <?php echo ($student['educ_level'] == 'College') ? 'selected' : ''; ?>>College</option>
        </select>

        <label>Year Level:</label>
        <input type="text" name="year_level" value="<?php echo htmlspecialchars($student['year_level']); ?>" required>

        <label>Section:</label>
        <input type="text" name="section" value="<?php echo htmlspecialchars($student['section']); ?>" required>

        <button type="submit">Update</button>
    </form>
    <a href="students.php">Back to Students</a>
</body>
</html>
