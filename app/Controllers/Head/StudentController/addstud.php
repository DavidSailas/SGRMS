<?php
include '../../../../database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_num = $_POST['id_num'];
    $prefix = $_POST['prefix'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $bod = $_POST['bod'];
    $sex = $_POST['gender']; // Use 'sex' for DB
    $address = $_POST['address'];
    $mobile_num = $_POST['mobile_num'];
    $email = $_POST['email'];
    $educ_level = $_POST['educ_level'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $previous_school = $_POST['previous_school'];
    $last_year_school = $_POST['last_year_school'];

    // Guardian/parent info
    $guardian_name = $_POST['guardian_name'];
    $relationship = $_POST['relationship'];
    $guardian_contact = $_POST['guardian_contact'];
    $guardian_email = $_POST['guardian_email'];

    // Handle image upload
    $default_image = '/Public/stud.img/default.png';
    $image = $_FILES['image']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/Public/stud.img/';
    $target_file = $target_dir . basename($image);

    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image_path = '/Public/stud.img/' . $image;
    } else {
        $image_path = $default_image;
    }

    // 1. Insert parent
    $parent_sql = "INSERT INTO parents (guardian_name, relationship, contact_num, email) VALUES (?, ?, ?, ?)";
    $parent_stmt = $conn->prepare($parent_sql);
    $parent_stmt->bind_param("ssss", $guardian_name, $relationship, $guardian_contact, $guardian_email);
    if (!$parent_stmt->execute()) {
        echo "Error creating parent record: " . $conn->error;
        exit();
    }
    $parent_id = $conn->insert_id;
    $parent_stmt->close();

    // 2. Insert student
    $stud_status = 'Active';
    $stud_sql = "INSERT INTO students (id_num, prefix, lname, fname, mname, sex, bod, address, mobile_num, email, educ_level, year_level, section, program, s_image, previous_school, last_year_school, status, parent_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stud_stmt = $conn->prepare($stud_sql);
    $stud_stmt->bind_param(
        "ssssssssssssssssssi",
        $id_num, $prefix, $lname, $fname, $mname, $sex, $bod,
        $address, $mobile_num, $email, $educ_level, $year_level, $section, $program,
        $image_path, $previous_school, $last_year_school, $stud_status, $parent_id
    );
    if (!$stud_stmt->execute()) {
        echo "Error creating student record: " . $conn->error;
        exit();
    }
    $student_id = $conn->insert_id;
    $stud_stmt->close();

    // 3. Create user account for student
    $username = $id_num;
    $last4 = substr($id_num, -4);
    $default_password = $lname . $last4;
    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
    $role = 'Student';
    $status = 'Active';
    $counselor_id = null; // Use NULL, not 0

    $user_sql = "INSERT INTO users (username, password, status, role, student_id, parent_id, counselor_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("ssssiii", $username, $hashed_password, $status, $role, $student_id, $parent_id, $counselor_id);
    if (!$user_stmt->execute()) {
        echo "Error creating user account: " . $conn->error;
        exit();
    }
    $user_stmt->close();

    header("Location: ../../../../resources/view/Head/students.php");
    exit();
}
?>
