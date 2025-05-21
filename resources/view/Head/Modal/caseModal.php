<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselor</title>
    <link rel="stylesheet" href="../../CSS/modal.css">
</head>
<body>
    <!-- caseModal.php -->
<div id="addCaseModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2>Add New Case</h2>
        <form action="../../../app/Controllers/Head/CaseController/addcase.php" method="POST">
            <div class="form-group">
                <label for="student_search">Student:</label>
                <div id="selectedStudentId" style="margin-bottom: 5px; font-weight: bold;"></div>
                <input list="student_list" id="student_search" name="student_search" autocomplete="off" placeholder="Type name...">
                <datalist id="student_list">
                    <?php
                    include '../../../../database/db_connect.php';
                    $studRes = $conn->query("SELECT s_id, lname, fname, id_num FROM students WHERE status = 'active'");
                    while ($stud = $studRes->fetch_assoc()) {
                        
                        echo "<option data-id='{$stud['s_id']}' data-idnum='{$stud['id_num']}' value='{$stud['lname']}, {$stud['fname']}'></option>";
                    }
                    ?>
                </datalist>
                <input type="hidden" id="student_id" name="student_id">
            </div>
            <div class="form-group">
                <label for="case_type">Case Type:</label>
                <select id="case_type" name="case_type" required>
                    <option value="">Select Case Type</option>
                    <option value="Behavioral">Behavioral</option>
                    <option value="Emotional">Emotional</option>
                    <option value="Peer Conflict">Peer Conflict</option>
                    <option value="Academic">Academic</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" ></textarea>
            </div>
            <div class="form-group">
                <label for="reported_by">Reported By:</label>
                <input type="text" id="reported_by" name="reported_by" >
            </div>
            <div class="form-group">
                <label for="referred_by">Referred By:</label>
                <input type="text" id="referred_by" name="referred_by" >
            </div>
            <div class="form-group">
                <label for="referral_date">Referral Date:</label>
                <input type="date" id="referral_date" name="referral_date" >
            </div>
            <div class="form-group">
                <label for="reason_for_referral">Reason for Referral:</label>
                <input type="text" id="reason_for_referral" name="reason_for_referral" >
            </div>
            <div class="form-group">
                <label for="presenting_problem">Presenting Problem:</label>
                <input type="text" id="presenting_problem" name="presenting_problem" >
            </div>
            <div class="form-group">
                <label for="observe_behavior">Observed Behavior:</label>
                <textarea id="observe_behavior" name="observe_behavior" ></textarea>
            </div>
            <div class="form-group">
                <label for="family_background">Family Background:</label>
                <input type="text" id="family_background" name="family_background" >
            </div>
            <div class="form-group">
                <label for="academic_history">Academic History:</label>
                <input type="text" id="academic_history" name="academic_history" >
            </div>
            <div class="form-group">
                <label for="social_relationships">Social Relationships:</label>
                <input type="text" id="social_relationships" name="social_relationships" >
            </div>
            <div class="form-group">
                <label for="medical_history">Medical History:</label>
                <input type="text" id="medical_history" name="medical_history" >
            </div>
            <div class="form-group">
                <label for="counselor_assessment">Counselor Assessment:</label>
                <textarea id="counselor_assessment" name="counselor_assessment" ></textarea>
            </div>
            <div class="form-group">
                <label for="recommendations">Recommendations:</label>
                <textarea id="recommendations" name="recommendations" ></textarea>
            </div>
            <div class="form-group">
                <label for="follow_up_plan">Follow-Up Plan:</label>
                <textarea id="follow_up_plan" name="follow_up_plan" ></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" >
                    <option value="Pending">Pending</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<!-- View Case Modal -->
<div id="viewCaseModal" class="modal">
    <div class="modal-content" id="viewCaseContent">
       
    </div>
</div>

<!-- Archive Confirmation Modal -->
<div id="archiveModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeArchiveModalBtn">&times;</span>
    <h3>Archive Case</h3>
    <p>Are you sure you want to archive this case?</p>
    <div style="text-align:right;">
      <button id="confirmArchiveBtn" class="btn btn-delete">Archive</button>
      <button id="cancelArchiveBtn" class="btn">Cancel</button>
    </div>
  </div>
</div>

</body>
</html>