<?php
    include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Counselors</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hg.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css">
    <script src="counselModal.js"></script>
    <style>
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            position: relative;
        }

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu.active {
            display: block;
        }

        .profiles-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .profile-box {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            width: 200px;
            height: 200px; /* Set a fixed height for the profile box */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative; /* For positioning the icon */
        }

        .profile-box img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block; /* Show image for counselors */
        }

        .add-profile-icon {
            font-size: 48px; /* Size of the plus icon */
            color: #4CAF50; /* Color of the plus icon */
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px; /* Max width for the modal */
            border-radius: 10px; /* Rounded corners */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
        <aside class="sidebar">
            <h1>SGRMS</h1>
            <ul>
                <li><a href="/SGRMS/HG/SuperAdmin/superadmin.php">Home</a></li>
                <li class="has-submenu">
                    <a href="#" id="profiling-link">Profiling</a>
                    <ul class="submenu" id="profiling-submenu">
                        <li><a href="/SGRMS/HG/Counselors/counsel.php">Counselors</a></li>
                        <li><a href="/SGRMS/HG/Teachers/teacher.php">Teachers</a></li>
                        <li><a href="/SGRMS/HG/Students/students.php">Students</a></li>
                    </ul>
                </li>
                <li><a href="/SGRMS/HG/Reports/case.php">Reports</a></li>
                <li><a href="/SGRMS/HG/Appointment/schedule.php">Appointments</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </aside>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profilingLink = document.getElementById("profiling-link");
            const profilingSubmenu = document.getElementById("profiling-submenu");

            profilingLink.addEventListener("click", function (event) {
                event.preventDefault();
                profilingSubmenu.classList.toggle("active");
            });

            document.addEventListener("click", function (event) {
                if (!profilingLink.contains(event.target) && !profilingSubmenu.contains(event.target)) {
                    profilingSubmenu.classList.remove("active");
                }
            });
        });
    </script>

    <div class="content">
        <h2>Manage Counselors</h2>
        <div class="profiles-container">
            <!-- Add new profile box -->
            <div class="profile-box" onclick="openFormModal()">
            <i class="fi fi-bs-plus"></i>
            </div>

            <?php
                $sql = "SELECT c.c_id, c.lname, c.fname, c.mname, c.contact_num, c.email, c.c_level, c.c_image, 
                                u.username, u.password 
                        FROM counselors c
                        JOIN users u 
                        ON c.u_id = u.u_id"; 

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fullName = $row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname'];
                        echo '<div class="profile-box" onclick="openModal(\'' . addslashes($row['c_image']) . '\', \'' . addslashes($fullName) . '\', \'' . addslashes($row['contact_num']) . '\', \'' . addslashes($row['email']) . '\', \'' . addslashes($row['c_level']) . '\', \'' . addslashes($row['username']) . '\')">';
                        echo '<img src="' . htmlspecialchars($row['c_image']) . '" alt="Profile Picture" />';
                        echo '<h2>' . htmlspecialchars($fullName) . '</h2>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No counselors found.</p>';
                }
                $conn->close();
            ?>
        </div>
    </div>
</div>

<!-- Modal for displaying counselor details -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalPicture" src="" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">
        <h2 id="modalName"></h2>
        <p><strong>Contact No.:</strong> <span id="modalContact"></span></p>
        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
        <p><strong>Counselor Level:</strong> <span id="modalLevel"></span></p>
        <p><strong>Username:</strong> <span id="modalUsername"></span></p>
        <p><strong>Password:</strong> ***********</p>
    </div>
</div>

<script>
    function openModal(picture, name, contact, email, level, username) {
        document.getElementById('modalPicture').src = picture;
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalContact').innerText = contact;
        document.getElementById('modalEmail').innerText = email;
        document.getElementById('modalLevel').innerText = level;
        document.getElementById('modalUsername').innerText = username;
        document.getElementById('profileModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('profileModal').style.display = "none";
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('profileModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

<!-- Include the form modal -->
<?php include 'formModal.php'; ?>
</body>
</html>