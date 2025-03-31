<!-- Add Teacher Modal -->
<div id="AddModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2>Add Teacher</h2>
        <form id="addTeacherForm" method="POST" action="addteach.php" enctype="multipart/form-data">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" >
            <label for="mname">Middle Name:</label>
            <input type="text" id="mname" name="mname">
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" >
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" >
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" >
            <label for="teach_level">Teaching Level:</label>
            <select id="teach_level" name="teach_level" >
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>
            <script>
                document.getElementById('teach_level').addEventListener('change', function() {
                    toggleFields();
                    updateYearLevel();
                });
            </script>
            <label for="year_level">Year Level:</label>
            <select id="year_level" name="year_level" >
                <option value="">Select Year Level</option>
            </select>
            <div id="programField" style="display: none;">
                <label for="program">Program:</label>
                <input type="text" id="program" name="program">
            </div>
            <div id="sectionField">
                <label for="section">Section:</label>
                <input type="text" id="section" name="section" >
            </div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" >
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" >
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div id="EditModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Teacher</h2>
        <form id="editTeacherForm" method="POST" action="editteach.php" enctype="multipart/form-data">
            <input type="hidden" id="edit_t_id" name="t_id">
            <input type="hidden" id="edit_u_id" name="u_id">  
            <label for="edit_fname">First Name:</label>
            <input type="text" id="edit_fname" name="fname" >
            <label for="edit_mname">Middle Name:</label>
            <input type="text" id="edit_mname" name="mname">
            <label for="edit_lname">Last Name:</label>
            <input type="text" id="edit_lname" name="lname" >
            <label for="edit_email">Email:</label>
            <input type="email" id="edit_email" name="email" >
            <label for="edit_phone">Phone:</label>
            <input type="text" id="edit_phone" name="phone" >
            <label for="edit_teach_level">Teaching Level:</label>
            <select id="edit_teach_level" name="teach_level" >
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>
            <script>
                document.getElementById('edit_teach_level').addEventListener('change', function() {
                    edittoggleFields();
                    updateEditYearLevel();
                });
            </script>
            <label for="edit_year_level">Year Level:</label>
            <select id="edit_year_level" name="year_level" >
                <option value="">Select Year Level</option>
            </select>
            <div id="edit_programField" style="display: none;">
                <label for="edit_program">Program:</label>
                <input type="text" id="edit_program" name="program">
            </div>
            <div id="edit_sectionField">
                <label for="edit_section">Section:</label>
                <input type="text" id="edit_section" name="section" >
            </div>
            <label for="edit_username">Username:</label>
            <input type="text" id="edit_username" name="username">
            <label for="edit_password">Password:</label>
            <input type="password" id="edit_password" name="password">
            <span class="password-toggle" onclick="openAuthPopup()">
            <i class="fi fi-ss-eye"></i>
            </span>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<!-- Authentication Modal -->
<div id="authPopup" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Password Authentication</h3>
        <input type="password" id="authPassword" placeholder="Enter Head Guidance Password">
        <button onclick="authenticatePassword()">Submit</button>
        <button onclick="closeAuthPopup()">Cancel</button>
    </div>
</div>


<script>

function toggleFields() {
    const teacherLevel = document.getElementById('teach_level').value;
    const programField = document.getElementById('programField');
    const sectionField = document.getElementById('sectionField');

    if (teacherLevel === 'College') {
        programField.style.display = 'block'; 
        sectionField.style.display = 'none';  
    } else {
        programField.style.display = 'none';  
        sectionField.style.display = 'block'; 
    }
}

function edittoggleFields() {
    const teacherLevel = document.getElementById('edit_teach_level').value;
    const programField = document.getElementById('edit_programField');
    const sectionField = document.getElementById('edit_sectionField');

    if (teacherLevel === 'College') {
        programField.style.display = 'block'; 
        sectionField.style.display = 'none';  
    } else {
        programField.style.display = 'none';  
        sectionField.style.display = 'block'; 
    }
}

function openModal() {
    document.getElementById("TeacherModal").style.display = "block";
}

function closeModal() {
    document.getElementById("TeacherModal").style.display = "none";
}

</script>

<!-- View Teacher Modal -->
<div id="viewTeacherModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeViewModal()">&times;</span>
        <h2 id="viewModalTitle">View Teacher</h2>
        <div id="TeacherData" class="Teacher-data">
            <div class="Teacher-details">
                <div class="data-item"><strong>Name:</strong> <span id="TeacherName"></span></div>
                <div class="data-item"><strong>Email:</strong> <span id="TeacherEmail"></span></div>
                <div class="data-item"><strong>Phone:</strong> <span id="TeacherPhone"></span></div>
                <div class="data-item"><strong>Teaching Level:</strong> <span id="TeacherTeachLevel"></span></div>
                <div class="data-item"><strong>Year Level:</strong> <span id="TeacherYearLevel"></span></div>
                <div class="data-item"><strong>Section/Program:</strong> <span id="TeacherSectionProgram"></span></div>
                <div class="data-item"><strong>Username:</strong> <span id="TeacherUsername"></span></div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
    }

    .close {
        color: #aaa;
        float: right;
        font-size : 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .data-item {
        margin: 10px 0;
    }
</style>