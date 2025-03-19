<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
/*
// After adding a new teacher
$activity = "Added a new teacher: {$teacher_name}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After updating a teacher
$activity = "Updated teacher ID: {$t_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After deleting a teacher
$activity = "Deleted teacher ID: {$t_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
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
            <section class="teacher-list">
                <div class="search-flex">
                    <h2>Teacher List</h2>                   
                    <div class="search-bar">
                        <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <select name="filter_educ" id="filter_educ">
                            <option value="">All Levels</option>
                            <option value="Elementary" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'Elementary') echo 'selected'; ?>>Elementary</option>
                            <option value="High School" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'High School') echo 'selected'; ?>>High School</option>
                            <option value="College" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'College') echo 'selected'; ?>>College</option>
                        </select>
                    </div>
                    <a href="addteach.php" class="btn btn-add">Add Teacher</a>
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
                    <tbody id="teacherTableBody">
                        <?php
                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $filter_educ = isset($_GET['filter_educ']) ? $_GET['filter_educ'] : '';
                            
                            $sql = "SELECT * FROM teachers WHERE (t_id LIKE ? OR fname LIKE ? OR lname LIKE ? )";
                            if (!empty($filter_educ)) {
                                $sql .= " AND educ_level = ?";
                            }
                            
                            $stmt = $conn->prepare($sql);
                            if (!empty($filter_educ)) {
                                $searchTerm = "%$search%";
                                $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $filter_educ);
                            } else {
                                $searchTerm = "%$search%";
                                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                            }
                            
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".htmlspecialchars($row['lname']).", ".htmlspecialchars($row['fname'])." ".htmlspecialchars($row['mname'])."</td>
                                        <td>".htmlspecialchars($row['email'])."</td>
                                        <td>".htmlspecialchars($row['phone'])."</td>
                                        <td>".htmlspecialchars($row['teach_level'])."</td>
                                        <td class='actions'>
                                            <a href='viewteach.php?t_id=".$row['t_id']."' class='btn btn-view'>View</a>
                                            <a href='editteach.php?t_id=".$row['t_id']."' class='btn btn-edit'>Edit</a>
                                            <a href='deleteteach.php?t_id=".$row['t_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this teacher?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No teachers found</td></tr>";
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
        var filter = document.getElementById('filter_educ').value;
        var url = "searchteach.php?search=" + encodeURIComponent(search) + "&filter_educ=" + encodeURIComponent(filter);
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('teacherTableBody').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
    
    document.getElementById('search').addEventListener('keyup', updateTable);
    document.getElementById('filter_educ').addEventListener('change', updateTable);
    </script>
</body>
</html>
