<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Guidance Reports Management System - Manage Students</title>
    <link rel="stylesheet" href="/SGRMS/CSS/stylestud.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">School Guidance Reports</div>
        <div>
            <a href="#">Dashboard</a>
            <a href="#">Reports</a>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
        </div>
    </nav>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="superadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="counsel.php"><i class="fas fa-users"></i> Counselors</a></li>
                <li><a href="teacher.php"><i class="fas fa-user-tie"></i> Teachers</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="case.php"><i class="fas fa-file-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="card">
                <section class="student-list">
                    <div class="search-flex">
                        <h2>Student List</h2>
                        <a href="addstud.php" class="btn btn-add">Add Student</a>
                        <div class="search-bar">
                            <!-- Search & Filter Inputs -->
                            <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Name"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <select name="filter_educ" id="filter_educ">
                                <option value="">All Levels</option>
                                <option value="Elementary" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'Elementary') echo 'selected'; ?>>Elementary</option>
                                <option value="High School" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'High School') echo 'selected'; ?>>High School</option>
                                <option value="College" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'College') echo 'selected'; ?>>College</option>
                            </select>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Educational Level</th>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            <?php
                                // Initially, display all students.
                                $sql = "SELECT s_id, lname, fname, mname, bod, educ_level, section FROM students";
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $bod = $row['bod'];
                                        $birthdate = new DateTime($bod);
                                        $today = new DateTime();
                                        $age = $today->diff($birthdate)->y;
                                        
                                        echo "<tr>
                                            <td><span class='status-circle green'></span></td>
                                            <td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
                                            <td>".$age."</td>
                                            <td>".$row['educ_level']."</td>
                                            <td>".$row['section']."</td>
                                            <td>
                                                <a href='viewstud.php?s_id=".$row['s_id']."' class='btn btn-view'>View</a>
                                                <a href='editstud.php?s_id=".$row['s_id']."' class='btn btn-edit'>Edit</a>
                                                <a href='deletestud.php?s_id=".$row['s_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No students found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
    
    <!-- JavaScript to perform live search using AJAX -->
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
    
    // Update table as the user types or changes the filter
    document.getElementById('search').addEventListener('keyup', updateTable);
    document.getElementById('filter_educ').addEventListener('change', updateTable);
    </script>
</body>
</html>
