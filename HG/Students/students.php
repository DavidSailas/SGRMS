<?php
include '../../Database/db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="../../CSS/style.css">
    <link rel="stylesheet" href="../../CSS/table.css">
    <script src="studModal.js"></script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h1>SGRMS</h1>
            <ul>
                <li><a href="../SuperAdmin/superadmin.php">Home</a></li>
                <li class="has-submenu">
                    <a href="#" id="profiling-link">Profiling</a>
                    <ul class="submenu" id="profiling-submenu">
                        <li><a href="../Counselors/counsel.php">Counselors</a></li>
                        <li><a href="../Teachers/teacher.php">Teachers</a></li>
                        <li><a href="../Students/students.php">Students</a></li>
                    </ul>
                </li>
                <li><a href="../Reports/case.php">Reports</a></li>
                <li><a href="../Appointment/schedule.php">Appointments</a></li>
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
            <section class="student-list">
    <div class="search-flex">
        <h2>Student List</h2>                       
        <div class="search-bar">
            <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Name">
            <select name="filter_educ" id="filter_educ">
                <option value="">All Levels</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>
        </div>
        <button class="btn btn-add" onclick="openAddModal()">Add Student</button>
    </div>

    <!-- ✅ Table scroll wrapper -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Educational Level</th>
                    <th>Section/Program</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                <?php
                    $sql = "SELECT s_id, id_num, prefix, lname, fname, mname, bod, educ_level, section, program FROM students";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $bod = $row['bod'];
                            $birthdate = new DateTime($bod);
                            $today = new DateTime();
                            $age = $today->diff($birthdate)->y;

                            echo "<tr>                                           
                                <td><span class='status-circle green'></span></td>
                                <td>".$row['id_num']."</td>
                                <td>".$row['prefix']." ".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
                                <td>".$age."</td>
                                <td>".$row['educ_level']."</td>
                                <td>".(!empty($row['section']) ? $row['section'] : $row['program'])."</td>
                                <td>
                                    <button class='btn btn-view' onclick='viewStudent(".$row['s_id'].")'>View</button>
                                    <button class='btn btn-edit' onclick='openEditModal(".$row['s_id'].")'>Edit</button>
                                    <button class='btn btn-delete' onclick='openDeleteConfirmationModal(".$row['s_id'].")'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No students found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>

            </div>
        </main>
    </div>
    <?php include 'formModal.php'; ?>
    <script>
        function updateTable() {
            var search = document.getElementById('search').value;
            var filter = document.getElementById('filter_educ').value;
            var url = "searchstud.php?search=" + encodeURIComponent(search) + "&filter_educ=" + encodeURIComponent(filter);
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('studentTableBody').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        document.getElementById('search').addEventListener('keyup', updateTable);
        document.getElementById('filter_educ').addEventListener('change', updateTable);
    </script>
</body>
</html>