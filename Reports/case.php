<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$sql = "SELECT case_id, academic_level, case_type, description, status FROM case_records";
$result = $conn->query($sql);

$conn->close();
/*
// After adding a new case
$activity = "Added a new case for student: {$student_name}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After updating a case
$activity = "Updated case ID: {$case_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After deleting a case
$activity = "Deleted case ID: {$case_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
    <style>
        .tab-container {
            display: flex;
            justify-content: center;
            border-bottom: 2px solid #007bff;
            margin-bottom: 15px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            color: #666;
            border: none;
            background: none;
        }
        .tab:hover, .tab.active {
            color: #007bff;
        }
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
        function filterCases(level) {
            let rows = document.querySelectorAll("#caseTable tbody tr");

            rows.forEach(row => {
                let academicLevel = row.cells[1].textContent.toLowerCase();
                let caseStatus = row.cells[3].textContent.toLowerCase();

                if (level === "all") {
                    row.style.display = ""; // Show all cases
                } else if (level === "pending") {
                    row.style.display = caseStatus === "pending" ? "" : "none";
                } else {
                    row.style.display = academicLevel.includes(level) ? "" : "none";
                }
            });

            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.getElementById(level + "Tab").classList.add('active');
        }

        function searchCases() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("#caseTable tbody tr");

            rows.forEach(row => {
                let caseID = row.cells[0].textContent.toLowerCase();
                let caseType = row.cells[2].textContent.toLowerCase();
                
                if (caseID.includes(input) || caseType.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
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
                <div class="search-flex">
                    <h2>Case Management</h2>                
                    <div class="search-bar">
                        <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Case Type..." onkeyup="searchCases()">
                        <select name="filter_educ" id="filter_educ">
                            <option value="">All Levels</option>
                            <option value="Elementary">Elementary</option>
                            <option value="High School">High School</option>
                            <option value="College">College</option>
                        </select>
                    </div>
                    <a href="add.case.php" class="btn btn-add">Add New Case</a>
                </div>
                
                <!-- Academic Level Tabs -->
                <div class="tab-container">
                    <button id="allTab" class="tab active" onclick="filterCases('all')">All Cases</button>
                    <button id="collegeTab" class="tab" onclick="filterCases('college')">College Cases</button>
                    <button id="highschoolTab" class="tab" onclick="filterCases('high school')">High School Cases</button>
                    <button id="elementaryTab" class="tab" onclick="filterCases('elementary')">Elementary Cases</button>
                    <button id="pendingTab" class="tab" onclick="filterCases('pending')">Pending Cases</button>
                </div>

                <div class="table-container">
                    <table id="caseTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Academic Level</th>
                                <th>Case Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['case_id']}</td>
                                                <td>{$row['academic_level']}</td>
                                                <td>{$row['case_type']}</td>
                                                <td>{$row['status']}</td>
                                                <td class='actions'>
                                                    <a href='case.view.php?id={$row['case_id']}' class='btn btn-view'>View</a>
                                                    <a href='case.update.php?id={$row['case_id']}' class='btn btn-edit'>Edit</a>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No records found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<?php $conn->close(); ?>

