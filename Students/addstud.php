<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields exist in $_POST
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
    $bod = isset($_POST['bod']) ? $_POST['bod'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $mobile_num = isset($_POST['mobile_num']) ? trim($_POST['mobile_num']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $educ_level = isset($_POST['educ_level']) ? $_POST['educ_level'] : '';
    $year_level = isset($_POST['year_level']) ? $_POST['year_level'] : '';
    $section = isset($_POST['section']) ? trim($_POST['section']) : '';

    // Validate Required Fields
    if (empty($lname) || empty($fname) || empty($bod) || empty($gender) || empty($address) ||
        empty($mobile_num) || empty($email) || empty($educ_level) || empty($year_level) || empty($section)) {
        die("All fields are required.");
    }

    // Insert into Database
    $sql = "INSERT INTO students (lname, fname, mname, bod, gender, address, mobile_num, email, educ_level, year_level, section) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $lname, $fname, $mname, $bod, $gender, $address, $mobile_num, $email, $educ_level, $year_level, $section);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #4a90e2;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #357ab8;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #4a90e2;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function calculateAge() {
            var bod = document.getElementById("bod").value;
            if (bod) {
                var today = new Date();
                var birthDate = new Date(bod);
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById("age").value = age;
            } else {
                document.getElementById("age").value = "";
            }
        }

        function updateYearLevel() {
            var eLevel = document.getElementById("educ_level").value;
            var yearLevelSelect = document.getElementById("year_level");
            
            yearLevelSelect.innerHTML = "<option value=''>Select Year Level</option>"; 
            
            if (eLevel === "Elementary") {
                for (var i = 1; i <= 6; i++) {
                    yearLevelSelect.innerHTML += "<option value='" + i + "'>Grade " + i + "</option>";
                }
            } else if (eLevel === "High School") {
                for (var i = 7; i <= 12; i++) {
                    yearLevelSelect.innerHTML += "<option value='" + i + "'>Grade " + i + "</option>";
                }
            } else if (eLevel === "College") {
                yearLevelSelect.innerHTML += `
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                `;
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <h2>Add Student</h2>
        <form action="addstud.php" method="POST">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" >

            <label for="fname">First Name:</label>
            <input type="text" name="fname" >

            <label for="mname">Middle Name:</label>
            <input type="text" name="mname" >

            <label for="bod">Date of Birth:</label>
            <input type="date" name="bod" id="bod" onchange="calculateAge()">

            <label for="age">Age (Auto-calculated, Not Stored):</label>
            <input type="text" id="age" readonly>

            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" name="address">

            <label for="mobile_num">Phone Number:</label>
            <input type="text" name="mobile_num">

            <label for="email">Email:</label>
            <input type="email" name="email">

            <label for="educ_level">Educational Level:</label>
            <select name="educ_level" id="educ_level" onchange="updateYearLevel()">
                <option value="">Select Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>

            <label for="year_level">Year Level:</label>
            <select name="year_level" id="year_level">
                <option value="">Select Year Level</option>
            </select>

            <label for="section">Section:</label>
            <input type="text" name="section">

            <button type="submit">Submit</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
