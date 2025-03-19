<?php
    include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

        // Initialize variables
        $totalCounselors = 0;
        $elementaryCounselors = 0;
        $highSchoolCounselors = 0;
        $collegeCounselors = 0;

        // Query to get total counselors
        $sql = "SELECT COUNT(*) as total FROM counselors";
        $result = $conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $totalCounselors = $row['total'];
        }

        // Query to get the count of counselors by level
        $sqlElementary = "SELECT COUNT(*) as total FROM counselors WHERE c_level = 'Elementary'";
        $resultElementary = $conn->query($sqlElementary);
        if ($resultElementary) {
            $row = $resultElementary->fetch_assoc();
            $elementaryCounselors = $row['total'];
        }

        $sqlHighSchool = "SELECT COUNT(*) as total FROM counselors WHERE c_level = 'HighSchool'";
        $resultHighSchool = $conn->query($sqlHighSchool);
        if ($resultHighSchool) {
            $row = $resultHighSchool->fetch_assoc();
            $highSchoolCounselors = $row['total'];
        }

        $sqlCollege = "SELECT COUNT(*) as total FROM counselors WHERE c_level = 'College'";
        $resultCollege = $conn->query($sqlCollege);
        if ($resultCollege) {
            $row = $resultCollege->fetch_assoc();
            $collegeCounselors = $row['total'];
        }
/*
        // After adding a new counselor
        $activity = "Added a new counselor: {$counselor_name}"; // Customize this message
        $conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

        // After updating a counselor
        $activity = "Updated counselor ID: {$c_id}"; // Customize this message
        $conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

        // After deleting a counselor
        $activity = "Deleted counselor ID: {$c_id}"; // Customize this message
        $conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Counselors</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hg.css">
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

    </style>

    <script>
        function searchCounselors() {
            var input = document.getElementById("search").value.toLowerCase();
            var table = document.querySelector("table tbody");
            var rows = table.querySelectorAll("tr");

            rows.forEach(row => {
                var name = row.cells[0].textContent.toLowerCase();
                var email = row.cells[1].textContent.toLowerCase();
                if (name.includes(input) || email.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
        function confirmDelete() {
            return confirm("Are you sure you want to delete this counselor?");
        }

    </script>
    </head>
    <body>
    <div class="container">
    <aside class="sidebar">
        <h1>SGRMS</h1>
        <ul>
            <li><a href="/SGRMS/SuperAdmin/superadmin.php">Home</a></li>
            <li class="has-submenu">
                <a href="#" id="profiling-link">Profiling</a>
                <ul class="submenu" id="profiling-submenu">
                    <li><a href="/SGRMS/Counselors/counsel.php">Counselors</a></li>
                    <li><a href="/SGRMS/Teachers/teacher.php">Teachers</a></li>
                    <li><a href="/SGRMS/Students/students.php">Students</a></li>
                </ul>
            </li>
            <li><a href="/SGRMS/Reports/case.php">Reports</a></li>
            <li><a href="/SGRMS/Appointment/schedule.php">Appointments</a></li>
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

        <main class="wrapper">
        <div class="card">
            <section class="dashboard-overview">
                <div class="stats">
                    <div class="stat-box1">
                        <h2>Total Counselors</h2>
                        <p><?php echo $totalCounselors; ?></p>
                    </div>
                    <div class="stat-box">
                        <h2>Elementary Counselors</h2>
                        <p><?php echo $elementaryCounselors; ?></p>
                    </div>
                    <div class="stat-box">
                        <h2>High School Counselors</h2>
                        <p><?php echo $highSchoolCounselors; ?></p>
                    </div>
                    <div class="stat-box">
                        <h2>College Counselors</h2>
                        <p><?php echo $collegeCounselors; ?></p>
                    </div>
                </div>
            </section>

                <section class="student-list">
                <div class="search-flex">
                    <h2>Manage Counselors</h2>                  
                    <div class="search-bar">
                        <input type="text" id="search" placeholder="Search by name or email" onkeyup="searchCounselors()">                     
                        <select id="level" name="level" onchange="filterCounselors()">
                                <option value="">All</option>
                                <option value="Elementary">Elementary</option>
                                <option value="High School">High School</option>
                                <option value="College">College</option>
                        </select>
                    </div>
                    <a href="addadmin.php" class="btn btn-add">Add Counselor</a>
                </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="counselTableBody">
                            <?php
                                $sql = "SELECT * FROM counselors";
                                $result = $conn->query($sql);

                                if (!$result) {
                                    die("<tr><td colspan='5'>Query failed: " . $conn->error . "</td></tr>");
                                }

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
                                            <td>".$row['email']."</td>
                                            <td>".$row['contact_num']."</td>
                                            <td>".$row['c_level']."</td>
                                            <td class='actions'>
                                                <a href='viewcounsel.php?c_id=".$row['c_id']."' class='btn btn-view'>View</a>
                                                <a href='editadmin.php?c_id=".$row['c_id']."' class='btn btn-edit'>Edit</a>
                                                <a href='deleteadmin.php?c_id=".$row['c_id']."' class='btn btn-delete' onclick='return confirmDelete();'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No counselors found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
    <script>
    function updateTable() {
        var search = document.getElementById('search').value;
        var filter = document.getElementById('level').value; // Ensure this matches the select element's ID
        var url = "searchcounsel.php?search=" + encodeURIComponent(search) + "&filter_educ=" + encodeURIComponent(filter);
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('counselTableBody').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
    
    document.getElementById('search').addEventListener('keyup', updateTable);
    document.getElementById('level').addEventListener('change', updateTable);
</script>
</body>
</html>
