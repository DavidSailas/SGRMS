<link rel="stylesheet" href="../../css/modal.css">

<!-- View Parent Modal -->
<div id="parentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="closeParentModal">&times;</span>
        <h2>Parent Details</h2>
        <form>
            <div class="form-group">
                <label for="modalName">Name:</label>
                <span id="modalName"></span>
            </div>

            <div class="form-group">
                <label for="modalRelationship">Relationship:</label>
                <span id="modalRelationship"></span>
            </div>

            <div class="form-group">
                <label for="modalContact">Contact:</label>
                <span id="modalContact"></span>
            </div>

            <div class="form-group">
                <label for="modalEmail">Email:</label>
                <span id="modalEmail"></span>
            </div>

            <div class="form-group">
                <label for="modalUsername">Username:</label>
                <span id="modalUsername"></span>
            </div>

            <div class="form-group">
                <label for="modalStatus">Account Status:</label>
                <span id="modalStatus"></span>
            </div>

            <hr style="margin: 20px 0;">

            <div style="margin-bottom: 10px;">
                <strong>Children</strong>
            </div>
            <ul id="modalChildren"></ul>
        </form>
    </div>
</div>


<!-- Edit Parent Modal -->
<div id="editParentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Edit Parent</h2>
        <form id="editParentForm">
            <input type="hidden" id="editParentId" name="p_id">

            <div class="form-group">
                <label for="editName">Parent Name:</label>
                <input type="text" id="editName" name="guardian_name" >
            </div>

            <div class="form-group">
                <label for="editRelationship">Relationship:</label>
                <input type="text" id="editRelationship" name="relationship" >
            </div>

            <div class="form-group">
                <label for="editContact">Contact Number:</label>
                <input type="text" id="editContact" name="contact_num" >
            </div>

            <div class="form-group">
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" >
            </div>

            <div class="form-group">
                <label for="editUsername">Username:</label>
                <input type="text" id="editUsername" name="username">
            </div>

            <div class="form-group">
                <label for="editStatus">Account Status:</label>
                <select id="editStatus" name="account_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>


<!-- Archive Confirmation Modal -->
<div id="archiveModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" id="closeArchiveModal">&times;</span>
        <h3>Confirm Archive</h3>
        <p>Are you sure you want to archive this parent?</p>
        <div class="modal-actions">
            <button id="confirmArchiveBtn" class="btn btn-danger">Yes, Archive</button>
            <button id="cancelArchiveBtn" class="btn">Cancel</button>
        </div>
    </div>
</div>
