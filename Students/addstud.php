<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_num = $_POST['id_num'];
    $prefix = $_POST['prefix'];
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
    $program = $_POST['program'];

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

    // Insert into database
    $sql = "INSERT INTO students (id_num, prefix, lname, fname, mname, bod, gender, address, mobile_num, email, educ_level, year_level, section, program, s_image) 
            VALUES ('$id_num', '$prefix', '$lname', '$fname', '$mname', '$bod', '$gender', '$address', '$mobile_num', '$email', '$educ_level', '$year_level', '$section', '$program', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to students.php after successful insertion
        header("Location: /SGRMS/Students/students.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>