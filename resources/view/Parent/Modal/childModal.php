<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/modal.css">
</head>
<body>
    <!-- Add -->
<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormModal()">&times;</span>
        <h2>Link your child</h2>
        <form id="addChildForm" action="../../../app/Controllers/Parent/ChildController/linkchild.php" method="POST">
            <input type="hidden" name="parent_id" value="<?php echo htmlspecialchars($_SESSION['parent_id'] ?? ''); ?>">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="sccnumber" >
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" >
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" >
            </div>
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" name="mname">
            </div>

            <!-- Relationship -->
            <div class="form-group">
                <label for="relationship">Relationship to Student</label>
                <select name="relationship" >
                    <option value="" disabled selected>Select relationship</option>
                    <option value="Mother">Mother</option>
                    <option value="Father">Father</option>
                    <option value="Guardian">Guardian</option>
                </select>
            </div>

            <!-- Optional Message -->
            <div class="form-group">
                <label for="message">Message to Counselor (Optional)</label>
                <textarea name="message" rows="3" placeholder="You may leave a message or note..."></textarea>
            </div>

             <!-- Buttons -->
            <div class="modal-buttons">
                <button type="submit" class="btn save">Confirm</button>
                <button type="button" class="btn cancel" onclick="closeFormModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- View -->
<div id="viewChildModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div id="studentDetails">
      <!-- Student details will load here via JS -->
    </div>
  </div>
</div>
</body>
</html>

