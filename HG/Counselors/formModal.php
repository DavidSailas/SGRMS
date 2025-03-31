<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFormModal()">&times;</span>
        <h2>Add Counselor</h2>
        <form action="addadmin.php" method="POST">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" >

            <label for="fname">First Name:</label>
            <input type="text" name="fname" >

            <label for="mname">Middle Name:</label>
            <input type="text" name="mname">

            <label for="email">Email:</label>
            <input type="email" name="email" >

            <label for="contact_num">Phone Number:</label>
            <input type="text" name="contact_num" >

            <label for="c_level">Department:</label>
            <select name="c_level" >
                <option value="">Select Department</option>
                <option value="Elementary">Elementary</option>
                <option value="Highschool">Highschool</option>
                <option value="College">College</option>
            </select>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" >
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" >
            <button type="submit">Save</button>
        </form>
        <button onclick="closeFormModal()">Cancel</button>
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