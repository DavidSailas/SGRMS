<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contact_num = isset($_POST['contact_num']) ? trim($_POST['contact_num']) : '';
    $c_level = isset($_POST['c_level']) ? trim($_POST['c_level']) : '';

    if (empty($lname) || empty($fname) || empty($email) || empty($contact_num) || empty($c_level)) {
        die("All fields are required.");
    }

    $sql = "INSERT INTO counselors (lname, fname, mname, email, contact_num, c_level) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $lname, $fname, $mname, $email, $contact_num, $c_level);

    if ($stmt->execute()) {
        echo "Counselor added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <title>Add Counselor</title>
</head>
<body>
    <div class="container">
        <h2>Add Counselor</h2>
        <form action="addadmin.php" method="POST">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" >

            <label for="fname">First Name:</label>
            <input type="text" name="fname" >

            <label for="mname">Middle Name:</label>
            <input type="text" name="mname">

            <label for="email">Email:</label>
            <input type="email" name="email" >

            <label for="contact_num">Phone Number:</label>
            <input type="text" name="contact_num" >

            <label for="c_level">Department:</label>
            <select name="c_level" >
                <option value="">Select Department</option>
                <option value="Elementary">Elementary</option>
                <option value="Highschool">Highschool</option>
                <option value="College">College</option>
            </select>

            <button type="submit">Submit</button>
        </form>
        <a href="counsel.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
