<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $section = isset($_POST['section']) && !empty($_POST['section']) ? $_POST['section'] : 'Not Assigned';
    $teach_level = $_POST['teach_level'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO teachers (lname, fname, mname, email, phone, section, teach_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $lname, $fname, $mname, $email, $phone, $section, $teach_level);
    
    if ($stmt->execute()) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
</head>
<body>
    <h2>Add Teacher</h2>
    <form method="POST" action="addteach.php">
        <label>Last Name:</label>
        <input type="text" name="lname" ><br>
        
        <label>First Name:</label>
        <input type="text" name="fname" ><br>
        
        <label>Middle Name:</label>
        <input type="text" name="mname"><br>
        
        <label>Email:</label>
        <input type="email" name="email" ><br>
        
        <label>Phone:</label>
        <input type="text" name="phone" ><br>
        
        <label>Section:</label>
        <input type="text" name="section" ><br> 
        
        <label>Department Level:</label>
        <select name="teach_level" >
            <option value="Elementary">Elementary</option>
            <option value="Highschool">Highschool</option>
            <option value="College">College</option>
        </select><br>
        
        <button type="submit">Submit</button>
    </form>
    <a href="teacher.php">Back to Home</a>
</body>
</html>
