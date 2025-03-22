<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link rel="stylesheet" href="appointments.css">

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
        <!-- Header -->
        <header class="header">
            <h1>Appointment Management</h1>
            <button id="showModalBtn" class="btn btn-primary">New Appointment</button>
        </header>

        <!-- Role Selector -->
        <section class="role-selector">
            <div id="roleCounselor" class="role-option">Guidance Counselor</div>
            <div id="roleRequester" class="role-option">Parent/Teacher</div>
        </section>

        <!-- View Selector -->
        <div class="view-selector">
            <button id="listViewBtn" class="active">List View</button>
            <button id="calendarViewBtn">Calendar View</button>

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
        <div class="container">
            <h2>Book an Appointment</h2>
            <form action="appointment.php" method="POST" class="appointment-form">
                <label for="s_id">Student ID:</label>
                <input type="number" name="s_id" >
                <label for="t_id">Teacher ID:</label>
                <input type="number" name="t_id" >
                <label for="p_id">Parent ID:</label>
                <input type="number" name="p_id">
                <label for="date">Date:</label>
                <input type="date" name="date" >
                <label for="time">Time:</label>
                <input type="time" name="time" >
                <label for="reason">Reason:</label>
                <textarea name="reason" ></textarea>
                <button type="submit" name="submit" class="btn">Book Appointment</button>
            </form>
        </div>

        <!-- List View -->
        <main id="listView" class="card">
            <section>
                <div class="filter-container">
                    <select id="filterStatus">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="completed">Completed</option>
                        <option value="canceled">Canceled</option>
                        <option value="no-show">No-Show</option>
                    </select>
                    <select id="filterRequester">
                        <option value="all">All Requesters</option>
                        <option value="parent">Parent</option>
                        <option value="teacher">Teacher</option>
                    </select>
                    <input type="date" id="filterDate">
                </div>
            </section>
            <section>
                <table id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date & Time</th>
                            <th>Requester</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        <!-- Appointments will be listed here -->
                    </tbody>
                </table>
            </section>
        </main>

        <!-- Calendar View -->
        <main id="calendarView" class="card" style="display: none;">
            <div class="view-selector">
                <button id="dayViewBtn">Day</button>
                <button id="weekViewBtn">Week</button>
                <button id="monthViewBtn" class="active">Month</button>
            </div>
            <div id="calendar" class="calendar">
                <div class="calendar-header">
                    <button id="prevBtn">Prev</button>
                    <span id="monthName"></span>
                    <button id="nextBtn">Next</button>
                </div>
                <div id="calendarGrid" class="calendar-grid"></div>
            </div>
        </main>

        <!-- New Appointment Modal -->
        <div id="newAppointmentModal" class="modal-backdrop" style="display: none;">
            <div class="modal">
                <h2>New Appointment</h2>
                <form id="newAppointmentForm">
                    <div>
                        <label>Student Name</label>
                        <input type="text" id="studentName" required>
                    </div>
                    <div id="requesterNameWrapper" style="display: none;">
                        <label>Your Name</label>
                        <input type="text" id="requesterName" required>
                    </div>
                    <div>
                        <label>Appointment Date</label>
                        <input type="date" id="appointmentDate" required>
                    </div>
                    <div>
                        <label>Appointment Time</label>
                        <input type="time" id="appointmentTime" required>
                    </div>
                    <div>
                        <label>Requester Type</label>
                        <select id="requesterType">
                            <option value="parent">Parent</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <div>
                        <label>Reason for Appointment</label>
                        <textarea id="appointmentReason" required></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="cancelModalBtn">Cancel</button>
                        <button type="submit" id="submitAppointmentBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    
<div id="appointmentDetailModal" class="modal-backdrop" style="display: none;">
    <div class="modal">
        <h2>Appointment Details</h2>
        <div id="appointmentDetailContent">
            <!-- Appointment details will be displayed here -->
        </div>
        <button id="closeDetailModalBtn">Close</button>
    </div>
</div>


        <!-- Appointment Detail Modal -->
        <div id="updateStatusSection" style="display: none;">
                    <h3>Update Session Status</h3>
                    <label for="appointmentStatus">Status:</label>
                    <select id="appointmentStatus">
                        <option value="completed">Completed</option>
                        <option value="no-show">No-Show</option>
                    </select>
                    <h3>Session Notes</h3>
                    <textarea id="sessionNotes" placeholder="Add notes or feedback" rows="4"></textarea>
                </div>

                <button id="updateAppointmentBtn">Update Appointment</button>
                <button id="closeDetailModalBtn">Close</button>
            </div>
        </div>

        <!-- Reschedule Modal -->
        <div id="rescheduleModal" class="modal-backdrop" style="display: none;">
            <div class="modal">
                <h2>Reschedule Appointment</h2>
                <form id="rescheduleForm">
                    <div>
                        <label>New Date</label>
                        <input type="date" id="rescheduleDate" required>
                    </div>
                    <div>
                        <label>New Time</label>
                        <input type="time" id="rescheduleTime" required>
                    </div>
                    <div>
                        <label>Reason for Rescheduling</label>
                        <textarea id="rescheduleReason" required></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="cancelRescheduleBtn">Cancel</button>
                        <button type="submit" id="submitRescheduleBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="appointments.js"></script>
</body>
</html>