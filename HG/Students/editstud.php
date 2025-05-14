<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s_id = $_POST['s_id'];
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
    $previous_school = $_POST['previous_school'];  
    $last_year_school = $_POST['last_year_school'];

    // Handle image upload
    $default_image = '/SGRMS/profile/circle-user.png'; // Default image path
    $image = $_FILES['image']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/SGRMS/profile/'; // Set target directory
    $target_file = $target_dir . basename($image);

    // Check if an image was uploaded
    if (!empty($image)) {
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image_path = '/SGRMS/profile/' . basename($image);
    } else {
        // If no new image is uploaded, keep the existing image
        $sql = "SELECT s_image FROM students WHERE s_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $s_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingImage = $result->fetch_assoc()['s_image'];
        $image_path = $existingImage ? $existingImage : $default_image;
    }

    $sql = "UPDATE students SET 
        id_num = ?, 
        prefix = ?, 
        lname = ?, 
        fname = ?, 
        mname = ?, 
        bod = ?, 
        gender = ?, 
        address = ?, 
        mobile_num = ?, 
        email = ?, 
        educ_level = ?, 
        year_level = ?, 
        section = ?, 
        program = ?, 
        s_image = ?,
        previous_school = ?, 
        last_year_school = ? 
        WHERE s_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssi", 
        $id_num, $prefix, $lname, $fname, $mname, $bod, $gender, $address, $mobile_num, $email, 
        $educ_level, $year_level, $section, $program, $image_path, $previous_school, $last_year_school, $s_id);
        
    if ($stmt->execute()) {
        
       header("Location: /SGRMS/HG/Students/students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
