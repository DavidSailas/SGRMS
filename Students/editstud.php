<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s_id = $_POST['s_id']; 
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $bod = $_POST['bod'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $mobile_num = $_POST['mobile_num'];
    $email = $_POST['email'];
    $educ_level = $_POST['educ_level'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];

    // Handle image upload
    $default_image = '/SGRMS/profile/circle-user.png'; // Default image path
    $image = $_FILES['image']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/SGRMS/profile/'; // Set target directory
    $target_file = $target_dir . basename($image);

    // Check if an image was uploaded
    if (!empty($image)) {
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        // Use the default image if no image was uploaded
        $target_file = $default_image;
    }

    // Update the student record in the database
    $sql = "UPDATE students SET lname='$lname', fname='$fname', mname='$mname', bod='$bod', gender='$gender', address='$address', mobile_num='$mobile_num', email='$email', educ_level='$educ_level', year_level='$year_level', section='$section', s_image='$target_file' WHERE s_id='$s_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to students.php after successful update
        header("Location: /SGRMS/Students/students.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>