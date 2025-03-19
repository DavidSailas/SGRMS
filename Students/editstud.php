<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_POST['save'])) {
    $s_id = $_POST['s_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $bod = $_POST['bod'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $mobile_num = $_POST['mobile_num'];
    $email = $_POST['email'];
    $educ_level = $_POST['educ_level'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];

    $sql = "UPDATE students SET fname=?, lname=?, mname=?, bod=?, gender=?, address=?, mobile_num=?, email=?, educ_level=?, year_level=?, section=?";
    
    if (!empty($_FILES['s_image']['name'])) {
        $image = $_FILES['s_image']['name'];
        $image_tmp = $_FILES['s_image']['tmp_name'];
        $image_path = "uploads/" . $image;

        move_uploaded_file($image_tmp, $image_path);

        $sql .= ", s_image=?";
    }
    
    $sql .= " WHERE s_id=?";
    $stmt = $conn->prepare($sql);

    if (!empty($_FILES['s_image']['name'])) {
        $stmt->bind_param("ssssssssssssi", $fname, $lname, $mname, $bod, $gender, $address, $mobile_num, $email, $educ_level, $year_level, $section, $image, $s_id);
    } else {
        $stmt->bind_param("sssssssssssi", $fname, $lname, $mname, $bod, $gender, $address, $mobile_num, $email, $educ_level, $year_level, $section, $s_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Student information updated successfully!');</script>";
        echo "<script>window.history.replaceState({}, document.title, '/SGRMS/Students/students.php'); location.reload();</script>";
    } else {
        echo "<script>alert('Error updating student information.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>