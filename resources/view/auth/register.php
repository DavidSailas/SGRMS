<?php
// register_parent.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; 
include '../../../database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Parent</title>
  <link rel="stylesheet" href="../../../resources/css/signup.css">

</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get form data
    $guardian_name = trim($_POST['guardian_name']);
    $relationship = trim($_POST['relationship']);
    $contact_num = trim($_POST['contact_num']);
    $email = trim($_POST['email']);

    $username = trim($_POST['username']);
    $plain_password = trim($_POST['password']);
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
    $role = "Parent";

    // 2. Insert into parents table
    $stmt1 = $conn->prepare("INSERT INTO parents (guardian_name, relationship, contact_num, email) VALUES (?, ?, ?, ?)");
    if ($stmt1) {
        $stmt1->bind_param("ssss", $guardian_name, $relationship, $contact_num, $email);

        if ($stmt1->execute()) {
            $parent_id = $stmt1->insert_id;

            // 3. Insert into users table
            $stmt2 = $conn->prepare("
                INSERT INTO users (username, password, role, parent_id, student_id, counselor_id)
                VALUES (?, ?, ?, ?, NULL, NULL)
            ");

            if ($stmt2) {
                $stmt2->bind_param("sssi", $username, $hashed_password, $role, $parent_id);
                if ($stmt2->execute()) {
                    echo '<p class="message">✅ Parent account registered successfully!</p>';

                    // 4. ✅ Send Email Notification
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';         // Replace with your SMTP server
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'jibbi.company@gmail.com';   // Your email
                        $mail->Password   = 'syen ozxx wgpi njmy';      // Your email password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        $mail->setFrom('jibbi.company@gmail.com', 'SGRMS Admin');
                        $mail->addAddress($email, $guardian_name);

                        $mail->isHTML(true);
                        $mail->Subject = 'Welcome to SGRMS!';
                        $mail->Body    = "Hi <b>$guardian_name</b>,<br><br>Your parent account has been successfully registered. You can now log in to the SGRMS Parent Portal.<br><br>Username: <b>$username</b><br><br>Thank you!";

                        $mail->send();
                    } catch (Exception $e) {
                        echo '<p class="message">⚠️ Email could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</p>';
                    }

                } else {
                    echo '<p class="message">❌ Error creating user: ' . $stmt2->error . '</p>';
                }
                $stmt2->close();
            } else {
                echo '<p class="message">❌ Error preparing user insert: ' . $conn->error . '</p>';
            }
        } else {
            echo '<p class="message">❌ Error inserting parent: ' . $stmt1->error . '</p>';
        }
        $stmt1->close();
    } else {
        echo '<p class="message">❌ Error preparing parent insert: ' . $conn->error . '</p>';
    }

    $conn->close();
}
?>

<!-- Your existing form -->
<form method="POST" action="register.php">
    <div class="form">
        <div class="form-left">
           <h1>Let us set up your Account</h1>
            <h4>Start monitoring your child's reports</h4>
            <p>
            As a parent, you’ll be able to keep an eye on your child’s progress through the school’s guidance system. Once you’re set up, you can:
            </p>
            <ul>
            <li>View summaries of your child's guidance sessions</li>
            <li>See updates about their behavior</li>
            <li>Request a meeting with the guidance counselor</li>
            <li>Get notified if there’s something important you should know</li>
            </ul>
            <p>
            Don’t worry — anything personal your child shares with the counselor stays private. You’ll only see the parts meant to keep you in the loop.
            </p>


        </div>
        <div class="form-right">
            <h3>Let's get started</h3>
            <label>Full Name:</label>
            <input type="text" name="guardian_name" >

            <label>Relationship:</label>
            <input type="text" name="relationship" >

            <label>Contact Number:</label>
            <input type="text" name="contact_num" >

            <label>Username:</label>
            <input type="text" name="username" >

            <label>Email:</label>
            <input type="email" name="email" >

            <label>Password:</label>
            <input type="password" name="password" >

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" >

            <button type="submit">Register Parent</button>
            <p>Already have an account or a student?</p>
            <a type="button" onclick="window.location.href='../../../index.php'" class="back-btn"> Log in instead</a>
        </div>
        
    </div>
 
</form>

</body>
</html>
