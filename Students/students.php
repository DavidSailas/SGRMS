<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
/*
// After adding a new student
$activity = "Added a new student: {$student_name}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After updating a student
$activity = "Updated student ID: {$s_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");

// After deleting a student
$activity = "Deleted student ID: {$s_id}"; // Customize this message
$conn->query("INSERT INTO activity_logs (activity, user_id) VALUES ('$activity', '{$_SESSION['user_id']}')");
*/
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            border-radius: 5px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
        /* General Button Styles */
        button {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border: none;
        }

        /* Save Button (Add & Edit Modals) */
        .btn-save {
            background-color: #4CAF50;
            color: white;
        }

        .btn-save:hover {
            background-color: #45a049;
            transform: translateY(-2px); /* Slight lift effect on hover */
        }

        .btn-save:active {
            background-color: #3e8e41;
        }

        /* Delete Button (For Delete Modal) */
        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .btn-danger:hover {
            background-color: #e53935;
            transform: translateY(-2px); /* Slight lift effect on hover */
        }

        .btn-danger:active {
            background-color: #d32f2f;
        }

        /* Cancel Button (For Add & Edit Modals) */
        .btn-secondary {
            background-color: #9e9e9e;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #757575;
            transform: translateY(-2px); /* Slight lift effect on hover */
        }

        .btn-secondary:active {
            background-color: #616161;
        }

        /* Yes Delete Button (For Delete Confirmation Modal) */
        .btn-delete-yes {
            background-color: #f44336;
            color: white;
            margin-right: 10px;
        }

        .btn-delete-yes:hover {
            background-color: #e53935;
            transform: translateY(-2px); /* Slight lift effect on hover */
        }

        .btn-delete-yes:active {
            background-color: #d32f2f;
        }

        /* Button Styles for Modal Forms */
        button:focus {
            outline: none;
        }

        /* Specific Modal Button Styles */
        .modal .btn {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
        }

        .modal .btn + .btn {
            margin-top: 10px;
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
                        <button class="btn btn-add" onclick="openModal()">Add Student</button>
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
                                                <button class='btn btn-view' onclick='viewStudent({$row['s_id']})'>View</button>
                                                <button class='btn btn-edit' onclick='editStudent({$row['s_id']})'>Edit</button>
                                                <button class='btn btn-delete' onclick='openDeleteModal({$row['s_id']})'>Delete</button>
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

    <!-- View Student Modal -->
    <div id="viewStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Student Details</h2>
            <div id="viewStudentDetails"></div> <!-- This is where student details will be displayed -->
        </div>
    </div>

    <!-- Delete Student Confirmation Modal -->
    <div id="deleteStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
            <h2>Are you sure you want to delete this student?</h2>
            <div>
                <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h2 id="modalTitle">Edit Student</h2>
            <form id="studentForm">
                <input type="hidden" name="s_id" value="">
                <label for="lname">Last Name:</label>
                <input type="text" name="lname" required>

                <label for="fname">First Name:</label>
                <input type="text" name="fname" required>

                <label for="mname">Middle Name:</label>
                <input type="text" name="mname">

                <label for="bod">Date of Birth:</label>
                <input type="date" name="bod" id="bod" required>

                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <label for="address">Address:</label>
                <input type="text" name="address" required>

                <label for="mobile_num">Mobile Number:</label>
                <input type="text" name="mobile_num" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="educ_level">Educational Level:</label>
                <select id="educ_level" name="educ_level">
                    <option value="">Select Educational Level</option>
                    <option value="Elementary">Elementary</option>
                    <option value="High School">High School</option>
                    <option value="College">College</option>
                </select>

                <label for="year_level">Year Level:</label>
                <select id="year_level" name="year_level">
                    <option value="">Select Year Level</option>
                </select>

                <label for="section">Section:</label>
                <input type="text" name="section" required>

                <label for="image">Profile Image:</label>
                <input type="file" name="image" accept="image/*"><br>
                <img src="/SGRMS/profile/circle-user.png" alt="Profile Image" id="previewImage" style="max-width: 100px; max-height: 100px;">

                <button type="submit" class="btn btn-save">Save</button>
            </form>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add Student</h2>
            <form id="studentForm">
                <input type="hidden" name="s_id" value="">
                <label for="lname">Last Name:</label>
                <input type="text" name="lname" required>

                <label for="fname">First Name:</label>
                <input type="text" name="fname" required>

                <label for="mname">Middle Name:</label>
                <input type="text" name="mname">

                <label for="bod">Date of Birth:</label>
                <input type="date" name="bod" id="bod" required>

                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <label for="address">Address:</label>
                <input type="text" name="address" required>

                <label for="mobile_num">Mobile Number:</label>
                <input type="text" name="mobile_num" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="educ_level">Educational Level:</label>
                <select id="educ_level" name="educ_level">
                    <option value="">Select Educational Level</option>
                    <option value="Elementary">Elementary</option>
                    <option value="High School">High School</option>
                    <option value="College">College</option>
                </select>

                <label for="year_level">Year Level:</label>
                <select id="year_level" name="year_level">
                    <option value="">Select Year Level</option>
                </select>

                <label for="section">Section:</label>
                <input type="text" name="section" required>

                <label for="image">Profile Image:</label>
                <input type="file" name="image" accept="image/*"><br>
                <img src="/SGRMS/profile/circle-user.png" alt="Profile Image" id="previewImage" style="max-width: 100px; max-height: 100px;">

                <button type="submit" class="btn btn-save">Save</button>
            </form>

            <p id="responseMessage"></p> <!-- Placeholder for success/error messages -->

            <script>

                document.addEventListener("DOMContentLoaded", function () {
                    const educLevel = document.getElementById("educ_level");
                    const yearLevel = document.getElementById("year_level");

                    educLevel.addEventListener("change", function () {
                        yearLevel.innerHTML = ""; // Clear current options

                        if (this.value === "Elementary") {
                            for (let i = 1; i <= 6; i++) {
                                let option = new Option(`Grade ${i}`, `Grade ${i}`);
                                yearLevel.add(option);
                            }
                        } else if (this.value === "High School") {
                            for (let i = 7; i <= 12; i++) {
                                let option = new Option(`Grade ${i}`, `Grade ${i}`);
                                yearLevel.add(option);
                            }
                        } else if (this.value === "College") {
                            let years = ["1st Year", "2nd Year", "3rd Year", "4th Year"];
                            years.forEach(year => {
                                let option = new Option(year, year);
                                yearLevel.add(option);
                            });
                        }
                    });
                });

                document.getElementById("image").addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById("previewImage").src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        document.getElementById("previewImage").src = "/SGRMS/profile/circle-user.png";
                    }
                });

                document.getElementById("studentForm").addEventListener("submit", function(event) {
                    event.preventDefault(); // Prevent default form submission

                    let formData = new FormData(this);

                    fetch("addstud.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("responseMessage").innerHTML = data;
                        closeModal(); // Close modal on success
                    })
                    .catch(error => console.error("Error:", error));
                });

                function openModal() {
            document.getElementById("addStudentModal").style.display = "block";
            document.getElementById("modalTitle").textContent = "Add Student";
        }

        function closeModal() {
            document.getElementById("addStudentModal").style.display = "none";
            document.getElementById("viewStudentModal").style.display = "none";
        }

        function editStudent(s_id) {
            fetch(`editstud.php?s_id=${s_id}`)
                .then(response => response.text())
                .then(data => {
                    let details = data.split("|");
                    if (details.length > 1) {
                        document.querySelector("input[name='s_id']").value = details[0];
                        document.querySelector("input[name='fname']").value = details[1];
                        document.querySelector("input[name='lname']").value = details[2];
                        document.querySelector("input[name='mname']").value = details[3];
                        document.querySelector("input[name='bod']").value = details[4];
                        document.querySelector("select[name='gender']").value = details[5];
                        document.querySelector("input[name='address']").value = details[6];
                        document.querySelector("input[name='mobile_num']").value = details[7];
                        document.querySelector("input[name='email']").value = details[8];
                        document.querySelector("select[name='educ_level']").value = details[9];
                        document.querySelector("select[name='year_level']").value = details[10];
                        document.querySelector("input[name='section']").value = details[11];

                        if (details[12]) {
                            document.getElementById("previewImage").src = details[12];
                        }

                        document.getElementById("editStudentModal").style.display = "block";
                    } else {
                        alert("Student not found!");
                    }
                });
        }

        function closeEditModal() {
            document.getElementById("editStudentModal").style.display = "none";
        }

        document.getElementById("studentForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch("editstud.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                closeEditModal();
                window.history.replaceState({}, document.title, "/SGRMS/Students/students.php"); // Remove query parameters
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        });

        function viewStudent(s_id) {
            document.getElementById("viewStudentModal").style.display = "block";
            fetch(`viewstud.php?s_id=${s_id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("viewStudentDetails").innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        function closeDeleteModal() {
            document.getElementById("deleteStudentModal").style.display = "none";
        }

        let deleteStudentId = null;
        function openDeleteModal(s_id) {
            deleteStudentId = s_id;
            document.getElementById("deleteStudentModal").style.display = "block";
        }

        document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
            fetch(`deletestudent.php?s_id=${deleteStudentId}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));

            closeDeleteModal();
        });

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
        </div>
    </div>
</body>
</html>
