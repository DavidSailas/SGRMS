<?php
include '../../../../database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_num = $_POST['id_num'];
    $suffix = $_POST['suffix'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $bod = $_POST['bod'];
    $sex = $_POST['gender'];
    $address = $_POST['address'];
    $mobile_num = $_POST['mobile_num'];
    $email = $_POST['email'];
    $educ_level = $_POST['educ_level'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $previous_school = $_POST['previous_school'];

    // Handle image upload
    $default_image = '/Public/stud.img/default.png';
    $image = $_FILES['image']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/Public/stud.img/';
    $target_file = $target_dir . basename($image);

    // Check if an image was uploaded
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image_path = '/Public/stud.img/' . $image;
    } else {
        $image_path = $default_image;
    }

    // Insert student data
    $sql = "INSERT INTO students (id_num, suffix, lname, fname, mname, bod, sex,
            address, mobile_num, email, educ_level, year_level, section, program,
            s_image, previous_school) 
            VALUES ('$id_num', '$suffix', '$lname', '$fname', '$mname', '$bod', '$sex',
            '$address', '$mobile_num', '$email', '$educ_level', '$year_level', '$section',
            '$program', '$image_path', '$previous_school')";

    if ($conn->query($sql) === TRUE) {

        // ✅ Automatically create user account
        $username = $id_num; // student uses ID number as login
        $last4 = substr($id_num, -4);
        $default_password = $lname . $last4;
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
        $role = 'Student';
        $status = 'Active';

        $user_sql = "INSERT INTO users (username, password, status, role)
                     VALUES ('$username', '$hashed_password', '$status', '$role')";

        if ($conn->query($user_sql) !== TRUE) {
            echo "Error creating user account: " . $conn->error;
        }

        header("Location: ../../../../resources/view/Head/students.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
