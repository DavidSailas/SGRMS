<?php
    include '../../../database/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $contact_num = trim($_POST['contact_num']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $plain_password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $role = "Parent";

        // Simple validation
        $errors = [];
        if ($plain_password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
        if (empty($first_name) || empty($last_name) || empty($contact_num) || empty($email) || empty($username) || empty($plain_password)) {
            $errors[] = "All fields are required.";
        }

        if (empty($errors)) {
            $guardian_name = $first_name . ' ' . $last_name;
            $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

            $stmt1 = $conn->prepare("INSERT INTO parents (guardian_name, relationship, contact_num, email) VALUES (?, ?, ?, ?)");
            $relationship = "Parent";
            if ($stmt1) {
                $stmt1->bind_param("ssss", $guardian_name, $relationship, $contact_num, $email);
                if ($stmt1->execute()) {
                    $parent_id = $stmt1->insert_id;
                    $stmt2 = $conn->prepare("INSERT INTO users (username, password, role, parent_id, student_id, counselor_id) VALUES (?, ?, ?, ?, NULL, NULL)");
                    if ($stmt2) {
                        $stmt2->bind_param("sssi", $username, $hashed_password, $role, $parent_id);
                        if ($stmt2->execute()) {
                            $success = "✅ Parent account registered successfully!";
                            header("Location: ../../../index.php");
                            exit();
                        } else {
                            $errors[] = "Error creating user: " . $stmt2->error;
                        }
                        $stmt2->close();
                    } else {
                        $errors[] = "Error preparing user insert: " . $conn->error;
                    }
                } else {
                    $errors[] = "Error inserting parent: " . $stmt1->error;
                }
                $stmt1->close();
            } else {
                $errors[] = "Error preparing parent insert: " . $conn->error;
            }
            $conn->close();
        }
    }
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Guidance Record Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../resources/css/signup.css">

  </head>
  <body>
    <div class="container" role="main">
      <section class="left-panel">
        <div>
        
          <h1 class="heading" lang="en"> Let’s setup your Parent <br /> Account </h1>
         
        </div>
      </section>
      <section class="right-panel" aria-label="Setup form">
        <h2 class="title">Register account</h2>
        <?php
          if (!empty($errors)) {
            foreach ($errors as $e) echo "<div class='error'>$e</div>";
          }
          if (!empty($success)) {
            echo "<div class='message'>$success</div>";
          }
        ?>
        <form method="POST" action="">
          <div class="form-row">
            <div class="form-group">
              <label for="first_name">First name</label>
              <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" />
            </div>
            <div class="form-group">
              <label for="last_name">Last name</label>
              <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" />
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 20px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="contact_num">Phone number</label>
                <input type="tel" id="contact_num" name="contact_num" placeholder="Enter your phone number" value="<?php echo isset($contact_num) ? htmlspecialchars($contact_num) : ''; ?>" aria-describedby="phone" />
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Create a password" />
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" />
            </div>
          </div>
          <button type="submit" aria-label="Get started">
            <span>Register Now</span>
          </button>
          <div class="switch-auth">
            <p>Already have an account or a student?</p>
            <a type="button" onclick="window.location.href='../../../index.php'" class="back-btn">Log in instead</a>
          </div>
        </form>
      </section>
    </div>
  </body>
</html>