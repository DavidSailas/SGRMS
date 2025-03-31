<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!isset($_GET['c_id']) || empty($_GET['c_id'])) {
    die("Invalid Counselor ID.");
}

$c_id = intval($_GET['c_id']);
$sql = "SELECT * FROM counselors WHERE c_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $c_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Counselor not found.");
}

$counselor = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = trim($_POST['lname']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $email = trim($_POST['email']);
    $contact_num = trim($_POST['contact_num']);
    $c_level = $_POST['c_level'];

    // Validate Required Fields
    if (empty($lname) || empty($fname) || empty($email) || empty($contact_num) || empty($c_level)) {
        die("All fields are required.");
    }

    // Update counselor record
    $sql = "UPDATE counselors SET lname=?, fname=?, mname=?, email=?, contact_num=?, c_level=? WHERE c_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $lname, $fname, $mname, $email, $contact_num, $c_level, $c_id);

    if ($stmt->execute()) {
        echo "Counselor updated successfully!";
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
    <title>Edit Counselor</title>
</head>
<body>
    <h2>Edit Counselor</h2>
    <form action="editadmin.php?c_id=<?php echo $c_id; ?>" method="POST">
        <label>Last Name:</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($counselor['lname']); ?>" required>

        <label>First Name:</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($counselor['fname']); ?>" required>

        <label>Middle Name:</label>
        <input type="text" name="mname" value="<?php echo htmlspecialchars($counselor['mname']); ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($counselor['email']); ?>" required>

        <label>Phone Number:</label>
        <input type="text" name="contact_num" value="<?php echo htmlspecialchars($counselor['contact_num']); ?>" required>

        <label>Department:</label>
        <select name="c_level" required>
            <option value="Elementary" <?php echo ($counselor['c_level'] == 'Elementary') ? 'selected' : ''; ?>>Elementary</option>
            <option value="High School" <?php echo ($counselor['c_level'] == 'High School') ? 'selected' : ''; ?>>High School</option>
            <option value="College" <?php echo ($counselor['c_level'] == 'College') ? 'selected' : ''; ?>>College</option>
        </select>

        <button type="submit">Update</button>
    </form>
    <a href="counsel.php">Back to Counselors</a>
</body>
</html>
