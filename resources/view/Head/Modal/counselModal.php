<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselor</title>
    <link rel="stylesheet" href="../../CSS/modal.css">
</head>
<body>

<!-- Add Modal -->
<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormModal()">&times;</span>
        <h2>Add Counselor</h2>
        <form action="../../../app/Controllers/Head/CounselorController/addcounsel.php" method="POST">
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" name="lname">
            </div>
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" name="fname">
            </div>
            <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" name="mname">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label for="contact_num">Phone Number:</label>
                <input type="text" name="contact_num">
            </div>
            <div class="form-group">
                <label for="c_level">Department:</label>
                <select name="c_level">
                    <option value="">Select Department</option>
                    <option value="Elementary">Elementary</option>
                    <option value="Highschool">Highschool</option>
                    <option value="College">College</option>
                </select>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn save">Save</button>
                <button type="button" class="btn cancel" onclick="closeFormModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- View Modal -->
<div id="viewCounselModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeViewCounselModal()">&times;</span>
        <h2>Counselor Details</h2>
        <div id="viewCounselContent">
            <div style="text-align:center;">
                <img id="view_c_image" src="../../Public/user.img/people.png" alt="Profile" style="width:100px;height:100px;border-radius:50%;margin-bottom:10px;">
            </div>
            <p><strong>Name:</strong> <span id="view_c_name"></span></p>
            <p><strong>Email:</strong> <span id="view_c_email"></span></p>
            <p><strong>Phone:</strong> <span id="view_c_contact"></span></p>
            <p><strong>Department:</strong> <span id="view_c_level"></span></p>
            <p><strong>Username:</strong> <span id="view_c_username"></span></p>
        </div>
        <div style="text-align:right; margin-top: 20px;">
            <button class="btn save" id="editCounselBtn" onclick="">Edit</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editCounselModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditCounselModal()">&times;</span>
        <h2>Edit Counselor</h2>
        <form id="editCounselForm" method="POST" action="../../../app/Controllers/Head/CounselorController/editcounsel.php">
            <input type="hidden" id="edit_c_id" name="c_id">
            <div class="form-group">
                <label for="edit_lname">Last Name:</label>
                <input type="text" id="edit_lname" name="lname" required>
            </div>
            <div class="form-group">
                <label for="edit_fname">First Name:</label>
                <input type="text" id="edit_fname" name="fname" required>
            </div>
            <div class="form-group">
                <label for="edit_mname">Middle Name:</label>
                <input type="text" id="edit_mname" name="mname">
            </div>
            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="edit_contact_num">Phone Number:</label>
                <input type="text" id="edit_contact_num" name="contact_num" required>
            </div>
            <div class="form-group">
                <label for="edit_c_level">Department:</label>
                <select id="edit_c_level" name="c_level" required>
                    <option value="">Select Department</option>
                    <option value="Elementary">Elementary</option>
                    <option value="Highschool">Highschool</option>
                    <option value="College">College</option>
                </select>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn save">Save</button>
                <button type="button" class="btn cancel" onclick="closeEditCounselModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
