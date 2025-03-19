<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and get input values
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : "";
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : "";
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : "";
    $bod = isset($_POST['bod']) ? trim($_POST['bod']) : "";
    $educ_level = isset($_POST['educ_level']) ? trim($_POST['educ_level']) : "";
    $year_level = isset($_POST['year_level']) ? trim($_POST['year_level']) : "";
    $section = isset($_POST['section']) ? trim($_POST['section']) : "";

    // Validate required fields
    if (empty($lname) || empty($fname) || empty($bod) || empty($educ_level) || empty($year_level) || empty($section)) {
        echo "All fields are required.";
        exit;
    }

    // Handle file upload for profile image
    $target_dir = "/SGRMS/profile/";
    $s_image = "/SGRMS/profile/circle-user.png"; // Default image

    if (!empty($_FILES['image']['name'])) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            // Create a unique filename to prevent overwrites
            $new_filename = uniqid("profile_", true) . "." . $imageFileType;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . $target_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $target_file)) {
                $s_image = $target_dir . $new_filename; // Save the path for the database
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit;
        }
    }

    // Insert student into the database
    $stmt = $conn->prepare("INSERT INTO students (lname, fname, mname, bod, educ_level, year_level, section, s_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $lname, $fname, $mname, $bod, $educ_level, $year_level, $section, $s_image);
    
    if ($stmt->execute()) {
        echo "Student added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>