<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="../../css/modal.css">
</head>
<body>
    <!-- Add Student Modal -->
<div id="addStudentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2 id="addModalTitle">Add Student</h2>
        <form id="addStudentForm" method="POST" action="../../../app/Controllers/Head/StudentController/addstud.php" enctype="multipart/form-data">
                
        <label for="id_num_display">Student ID:</label>
        <span id="id_num_display">Loading...</span>
        <input type="hidden" id="id_num" name="id_num">

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <img id="studentImage" src="../../Public/stud.img/circle-user.png" alt="Student Image" style="display: none; width: 100px; height: auto; margin-top: 10px;">
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" placeholder="Enter last name">

            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" placeholder="Enter first name">

            <label for="mname">Middle Name:</label>
            <input type="text" id="mname" name="mname" placeholder="Enter middle name">
            
            <label for="suffix">Suffix:</label>
            <input type="text" id="suffix" name="suffix" placeholder=" e.g. Jr., Sr., III">
            
            <label for="bod">Birthdate:</label>
            <input type="date" id="bod" name="bod">

            <label for="gender">Sex:</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter address">

            <label for="mobile_num">Mobile No:</label>
            <input type="text" id="mobile_num" name="mobile_num" placeholder="Enter mobile number">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email">

            <label for="educ_level">Educational Level:</label>
            <select id="educ_level" name="educ_level">
                <option value="">Select Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>

            <script>
                document.getElementById('educ_level').addEventListener('change', function() {
                    toggleFields();
                    updateYearLevel();
                });
            </script>
            <label for="year_level">Year Level:</label>
            <select id="year_level" name="year_level">
                <option value="">Select Year Level</option>
            </select>

            <div id="programField" style="display: none;">
                <label for="program">Program:</label>
                <input type="text" id="program" name="program" placeholder="Enter program name">
            </div>

            <div id="sectionField">
                <label for="section">Section:</label>
                <input type="text" id="section" name="section" placeholder="Enter section name">
            </div>

            <label for="previous_school">Previous School:</label>
            <input type="text" id="previous_school" name="previous_school" placeholder="Enter previous school name">
            
            <hr style="margin: 20px 0;">

            <div style="margin-bottom: 10px;">
                <strong>Guardain Information</strong>
            </div>
            <div class="form-group">
                <label for="guardian_name">Guardian Name:</label>
                <input type="text"  placeholder="Enter guardian's name">
            </div>
            <div class="form-group">
                <label for="relationship">Relationship:</label>
                <input type="text"   placeholder="e.g. Mother, Father, Guardian">
            </div>
            <div class="form-group">
                <label for="guardian_contact">Guardian Contact:</label>
                <input type="text"   placeholder="Enter guardian's contact number">
            </div>
            <div class="form-group">
                <label for="guardian_email">Guardian Email:</label>
                <input type="email"   placeholder="Enter guardian's email" required>
            </div>

            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editStudentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 id="editModalTitle">Edit Student</h2>
        <form id="editStudentForm" method="POST" action="../../../app/Controllers/Head/StudentController/editstud.php" enctype="multipart/form-data">
            <input type="hidden" id="edit_s_id" name="s_id"> 
            <label for="edit_id_num">Student ID:</label>
            <span id="edit_id_num_display"><i>Loading...</i></span> 
            <input type="hidden" id="edit_id_num" name="id_num">
            
            <label for="edit_suffix">Suffix:</label>
            <input type="text" id="edit_suffix" name="suffix" placeholder="e.g. Jr., Sr., III">
            
            <label for="edit_lname">Last Name:</label>
            <input type="text" id="edit_lname" name="lname" placeholder="Enter last name">

            <label for="edit_fname">First Name:</label> 
            <input type="text" id="edit_fname" name="fname" placeholder="Enter first name">

            <label for="edit_mname">Middle Name:</label>
            <input type="text" id="edit_mname" name="mname" placeholder="Enter middle name">

            <label for="edit_bod">Birthdate:</label>
            <input type="date" id="edit_bod" name="bod">

            <label for="edit_gender">Sex:</label>
            <select id="edit_gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="edit_address">Address:</label>
            <input type="text" id="edit_address" name="address" placeholder="Enter address">

            <label for="edit_mobile_num">Mobile No:</label>
            <input type="text" id="edit_mobile_num" name="mobile_num" placeholder="Enter mobile number">

            <label for="edit_email">Email:</label>
            <input type="email" id="edit_email" name="email" placeholder="Enter email">

            <label for="edit_educ_level">Educational Level:</label>
            <select id="edit_educ_level" name="educ_level">
                <option value="">Select Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>

            <script>
                document.getElementById('edit_educ_level').addEventListener('change', function() {
                    edittoggleFields();
                    updateEditYearLevel();
                });
            </script>

            <label for="edit_year_level">Year Level:</label>
            <select id="edit_year_level" name="year_level">
                <option value="">Select Year Level</option>
            </select>

            <div id="edit_programField" style="display: none;">
                <label for="edit_program">Program:</label>
                <input type="text" id="edit_program" name="program" placeholder="Enter program name">
            </div>

            <div id="edit_sectionField">
                <label for="edit_section">Section:</label>
                <input type="text" id="edit_section" name="section" placeholder="Enter section name"> 
            </div>

            <label for="edit_previous_school">Previous School:</label>
            <input type="text" id="edit_previous_school" name="previous_school" placeholder="Enter previous school name">

            <label for="edit_image">Image:</label>
            <input type="file" id="edit_image" name="image" accept="image/*">
            <img id="edit_studentImage" src="../../Public/stud.img/circle-user.png" alt="Student Image" style="display: none; width: 100px; height: auto; margin-top: 10px;">

            <hr style="margin: 20px 0;">
            <div style="margin-bottom: 10px;">
                <strong>In case of emergency</strong>
            </div>
            <div class="form-group">
                <label for="edit_guardian_name">Guardian Name:</label>
                <input type="text" id="edit_guardian_name" name="guardian_name" placeholder="Enter guardian's name">
            </div>
            <div class="form-group">
                <label for="edit_relationship">Relationship:</label>
                <input type="text" id="edit_relationship" name="relationship" placeholder="e.g. Mother, Father, Aunt">
            </div>
            <div class="form-group">
                <label for="edit_guardian_contact">Guardian Contact:</label>
                <input type="text" id="edit_guardian_contact" name="guardian_contact" placeholder="Enter guardian's contact number">
            </div>
            <div class="form-group">
                <label for="edit_guardian_email">Guardian Email:</label>
                <input type="email" id="edit_guardian_email" name="guardian_email" placeholder="Enter guardian's email " required>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</div>

<script>
    function edittoggleFields() {
        const educLevel = document.getElementById('edit_educ_level').value; 
        const programField = document.getElementById('edit_programField');
        const sectionField = document.getElementById('edit_sectionField');

        if (educLevel === 'College') {
            programField.style.display = 'block'; 
            sectionField.style.display = 'none';  
        } else {
            programField.style.display = 'none'; 
            sectionField.style.display = 'block'; 
        }
    }

    function toggleFields() {
        const educLevel = document.getElementById('educ_level').value;
        const programField = document.getElementById('programField');
        const sectionField = document.getElementById('sectionField');

        if (educLevel === 'College') {
            programField.style.display = 'block'; 
            sectionField.style.display = 'none';  
        } else {
            programField.style.display = 'none';  
            sectionField.style.display = 'block'; 
        }
    }

    function openModal() {
        document.getElementById("studentModal").style.display = "block";
        fetchStudentId(); 
    }

    function closeModal() {
        document.getElementById("studentModal").style.display = "none";
    }

function fetchStudentId() {
    const idNumDisplay = document.getElementById('id_num_display');
    const idNumHidden = document.getElementById('id_num');
fetch('../../../app/Controllers/Head/StudentController/getstudNum.php')
    .then(response => {
        console.log('Response status:', response.status); // Log the response status
        if (!response.ok) {
            throw new Error('Failed to fetch student ID');
        }
        return response.text();
    })
    .then(data => {
        console.log('Fetched data:', data); // Log the fetched data
        idNumDisplay.textContent = data; // Display the ID
        idNumHidden.value = data; // Set the hidden input value
    })
    .catch(error => {
        console.error('Error fetching student ID:', error);
        idNumDisplay.textContent = 'Error generating ID';
    });
}
</script>


<!-- View -->
<div id="viewStudentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeViewModal()">&times;</span>
        <h2 id="viewModalTitle">View Student</h2>
        <div id="studentData" class="student-data">
            <div class="student-image">
                <img id="viewStudentImage" src="" alt="Student Image" style="max-width: 200px; max-height: 200px; display: none;">
            </div>
            <div class="student-details">
                <div class="data-item"><strong>Student ID:</strong> <span id="studentId"></span></div>
                <div class="data-item"><strong>Name:</strong> <span id="studentName"></span></div>
                <div class="data-item"><strong>Age:</strong> <span id="studentAge"></span></div>
                <div class="data-item"><strong>Date of Birth:</strong> <span id="studentDOB"></span></div>
                <div class="data-item"><strong>Sex:</strong> <span id="studentSex"></span></div>
                <div class="data-item"><strong>Address:</strong> <span id="studentAddress"></span></div> 
                <div class="data-item"><strong>Mobile No:</strong> <span id="studentMobile"></span></div>
                <div class="data-item"><strong>Email:</strong> <span id="studentEmail"></span></div>
                <div class="data-item"><strong>Educational Level:</strong> <span id="studentEducLevel"></span></div>
                <div class="data-item"><strong>Year Level:</strong> <span id="studentYearLevel"></span></div>
                <div class="data-item"><strong>Section/Program:</strong> <span id="studentSectionProgram"></span></div>
                <div class="data-item"><strong>Previous School:</strong> <span id="studentPreviousSchool"></span></div>
                <h2 style="margin-top: 20px;">Guardian Information</h2>
                <div class="data-item"><strong>Guardian Name:</strong> <span id="viewGuardianName"></span></div>
                <div class="data-item"><strong>Relationship:</strong> <span id="viewRelationship"></span></div>
                <div class="data-item"><strong>Guardian Contact:</strong> <span id="viewGuardianContact"></span></div>
                <div class="data-item"><strong>Guardian Email:</strong> <span id="viewGuardianEmail"></span></div>
                <h2 style="margin-top: 20px;">Case Records</h2>
                <div id="caseRecordsContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation -->
<div id="deleteConfirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteConfirmationModal()">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this student?</p>
        <button id="confirmDeleteButton" class="btn btn-delete" onclick="confirmDelete()">Delete</button>
        <button class="btn btn-cancel" onclick="closeDeleteConfirmationModal()">Cancel</button>
    </div>
</div>

</body>
</html>