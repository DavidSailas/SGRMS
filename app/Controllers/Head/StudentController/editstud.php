<?php
include '../../../../database/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $s_id = $_POST['s_id'];
    $action = $_POST['action'] ?? 'update'; 

    if ($action === 'drop') {
        
        $sql = "UPDATE students SET status = 'Inactive' WHERE s_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $s_id);
        if ($stmt->execute()) {
            header("Location: ../../../../resources/view/Head/students.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // existing update code
        $id_num = $_POST['id_num'];
        $suffix = $_POST['suffix'];
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
            $stmt->close();
        }

        $sql = "UPDATE students SET 
            id_num = ?, 
            suffix = ?, 
            lname = ?, 
            fname = ?, 
            mname = ?, 
            bod = ?, 
            sex = ?, 
            address = ?, 
            mobile_num = ?, 
            email = ?, 
            educ_level = ?, 
            year_level = ?, 
            section = ?, 
            program = ?, 
            s_image = ?,
            previous_school = ?
            WHERE s_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssssssi", 
            $id_num, $suffix, $lname, $fname, $mname, $bod, $sex, $address, $mobile_num, $email, 
            $educ_level, $year_level, $section, $program, $image_path, $previous_school, $s_id);
            
        if ($stmt->execute()) {
            // Update parent/guardian info
            $get_parent = $conn->prepare("SELECT parent_id FROM students WHERE s_id = ?");
            $get_parent->bind_param("i", $s_id);
            $get_parent->execute();
            $get_parent->bind_result($parent_id);
            $get_parent->fetch();
            $get_parent->close();

            $guardian_name = $_POST['guardian_name'];
            $relationship = $_POST['relationship'];
            $guardian_contact = $_POST['guardian_contact'];
            $guardian_email = $_POST['guardian_email'];

            $parent_sql = "UPDATE parents SET guardian_name=?, relationship=?, contact_num=?, email=? WHERE p_id=?";
            $parent_stmt = $conn->prepare($parent_sql);
            $parent_stmt->bind_param("ssssi", $guardian_name, $relationship, $guardian_contact, $guardian_email, $parent_id);
            $parent_stmt->execute();
            $parent_stmt->close();

            header("Location: ../../../../resources/view/Head/students.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}

?>

