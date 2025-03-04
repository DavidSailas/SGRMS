<?php
    include 'db_connect.php';

    $id = $_GET['id'];
    $sql = "SELECT * FROM counselors WHERE c_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];

        $update_sql = "UPDATE counselors SET lname='$lname', fname='$fname', mname='$mname', email='$email', phone='$phone', role='$role' WHERE c_id=$id";

        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Counselor updated successfully'); window.location='manage_admins.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Counselor</title>
</head>
<body>
    <h2>Edit Counselor</h2>
    <form method="post">
        <label>Last Name:</label>
        <input type="text" name="lname" value="<?= $row['lname'] ?>" required><br>

        <label>First Name:</label>
        <input type="text" name="fname" value="<?= $row['fname'] ?>" required><br>

        <label>Middle Name:</label>
        <input type="text" name="mname" value="<?= $row['mname'] ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $row['email'] ?>" required><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= $row['phone'] ?>" required><br>

        <label>Role:</label>
        <input type="text" name="role" value="<?= $row['role'] ?>" required><br>

        <button type="submit">Update Counselor</button>
    </form>
</body>
</html>
