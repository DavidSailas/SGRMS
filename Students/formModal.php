<!-- Add and Edit -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Add Student</h2>
        <form id="studentForm" method="POST" action="addstud.php" enctype="multipart/form-data">
            <input type="hidden" id="s_id" name="s_id"> 
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname">
            <label for="mname">Middle Name:</label>
            <input type="text" id="mname" name="mname">
            <label for="bod">Birthdate:</label>
            <input type="date" id="bod" name="bod">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
            <label for="mobile_num">Mobile No:</label>
            <input type="text" id="mobile_num" name="mobile_num">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="educ_level">Educational Level:</label>
            <select id="educ_level" name="educ_level" onchange="updateYearLevel()">
                <option value="">Select Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="College">College</option>
            </select>
            <label for="year_level">Year Level:</label>
            <select id="year_level" name="year_level">
                <option value="">Select Year Level</option>
            </select>
            <label for="section">Section:</label>
            <input type="text" id="section" name="section">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <img id="studentImage" src="/SGRMS/profile/circle-user.png" alt="Student Image" style="display: none; width: 100px; height: auto; margin-top: 10px;">
            <button type="submit">Save</button>
        </form>
    </div>
</div>

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
                <div class="data-item"><strong>Name:</strong> <span id="studentName"></span></div>
                <div class="data-item"><strong>Age:</strong> <span id="studentAge"></span></div>
                <div class="data-item"><strong>Date of Birth:</strong> <span id="studentDOB"></span></div>
                <div class="data-item"><strong>Sex:</strong> <span id="studentSex"></span></div>
                <div class="data-item"><strong>Address:</strong> <span id="studentAddress"></span></div>
                <div class="data-item"><strong>Mobile No:</strong> <span id="studentMobile"></span></div>
                <div class="data-item"><strong>Email:</strong> <span id="studentEmail"></span></div>
                <div class="data-item"><strong>Educational Level:</strong> <span id="studentEducLevel"></span></div>
                <div class="data-item"><strong>Year Level:</strong> <span id="studentYearLevel"></span></div>
                <div class="data-item"><strong>Section:</strong> <span id="studentSection"></span></div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation -->
<div id="deleteConfirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteConfirmationModal()">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this student record?</p>
        <button id="confirmDeleteButton">Delete</button>
        <button onclick="closeDeleteConfirmationModal()">Cancel</button>
    </div>
</div>

<!-- style -->
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