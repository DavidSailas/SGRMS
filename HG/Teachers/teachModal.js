// Add
function openAddModal() {
    document.getElementById('AddModal').style.display = 'block';
}

function closeAddModal() {
    document.getElementById('AddModal').style.display = 'none';
    document.getElementById('addTeacherForm').reset(); 
}

// Authentication
let originalPassword = "";

function openAuthPopup() {
    document.getElementById("authPopup").style.display = "block";
}

function closeAuthPopup() {
    document.getElementById("authPopup").style.display = "none";
    document.getElementById("authPassword").value = "";
}

function authenticatePassword() {
    const enteredPassword = document.getElementById("authPassword").value;

    fetch("getHGpass.php", { // ✅ FIXED FILE NAME
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "authPassword=" + encodeURIComponent(enteredPassword)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            originalPassword = data.password;
            document.getElementById("edit_password").type = "text";
            document.getElementById("edit_password").value = originalPassword;
            closeAuthPopup();
        } else {
            alert("Incorrect password!");
        }
    })
    .catch(error => console.error("Error:", error));
}

document.addEventListener("DOMContentLoaded", function () {
    const passwordToggle = document.querySelector(".password-toggle");
    if (passwordToggle) {
        passwordToggle.addEventListener("click", function () {
            const passwordField = document.getElementById("edit_password");

            if (passwordField.type === "password") {
                if (originalPassword) {
                    passwordField.type = "text";
                    passwordField.value = originalPassword; // Show password
                } else {
                    openAuthPopup();
                }
            } else {
                passwordField.type = "password";
                passwordField.value = "***********"; // Hide password
            }
        });
    }
});



// Update 
function openEditModal(Id) {
    fetch(`fetchteach.php?t_id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('edit_t_id').value = data.t_id; 
                document.getElementById('edit_u_id').value = data.u_id;
                document.getElementById('edit_fname').value = data.fname;
                document.getElementById('edit_mname').value = data.mname;
                document.getElementById('edit_lname').value = data.lname;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_phone').value = data.phone;
                document.getElementById('edit_teach_level').value = data.teach_level;
                updateEditYearLevel();
                document.getElementById('edit_year_level').value = data.year_level; 
                if (data.teach_level === 'College') {
                    document.getElementById('edit_program').value = data.program; 
                    document.getElementById('edit_programField').style.display = 'block'; 
                    document.getElementById('edit_sectionField').style.display = 'none'; 
                } else {
                    document.getElementById('edit_section').value = data.section; 
                    document.getElementById('edit_programField').style.display = 'none'; 
                    document.getElementById('edit_sectionField').style.display = 'block'; 
                }
                document.getElementById('edit_username').value = data.username;
                document.getElementById('edit_password').value = data.password;  
              /*document.getElementById('edit_password').setAttribute('data-original-password', data.password);*/
                document.getElementById("EditModal").style.display = "block";
            } else {
                console.error(data.error);
                alert("Error: " + data.error);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

function closeEditModal() {
    document.getElementById('EditModal').style.display = 'none';
    document.getElementById('editTeacherForm').reset(); // Reset the form fields
}

// View
function viewTeacher(Id) {
    console.log("View Teacher ID:", Id); // Debugging
    document.getElementById('viewModalTitle').innerText = "View Teacher";
    document.getElementById('viewTeacherModal').style.display = 'block';

    fetch(`viewteach.php?t_id=${Id}`)
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Data:", data); // Debugging
            if (!data.error) {
                document.getElementById('TeacherName').textContent = `${data.lname}, ${data.fname} ${data.mname}`;
                document.getElementById('TeacherEmail').textContent = data.email;
                document.getElementById('TeacherPhone').textContent = data.phone;
                document.getElementById('TeacherTeachLevel').textContent = data.teach_level;
                document.getElementById('TeacherYearLevel').textContent = data.year_level;
                document.getElementById('TeacherSectionProgram').textContent = data.teach_level === 'College' ? data.program : data.section;
                document.getElementById('TeacherUsername').textContent = data.username;
            } else {
                console.error(data.error);
                alert("Error: " + data.error);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

function closeViewModal() {
    document.getElementById('viewTeacherModal').style.display = 'none';
}

// Close 
window.onclick = function(event) {
    const addModal = document.getElementById('AddModal');
    const editModal = document.getElementById('EditModal');
    const viewModal = document.getElementById('viewTeacherModal');
    const authModal = document.getElementById('AuthModal');
    if (event.target == addModal) {
        closeAddModal();
    } else if (event.target == editModal) {
        closeEditModal();
    } else if (event.target == viewModal){
        closeViewModal();
    } else if (event.target == authModal) {
        closeAuthModal();
    }
}

// Year level for Add
function updateYearLevel() {
    const Level = document.getElementById("teach_level").value;
    const yearLevelSelect = document.getElementById("year_level");
    yearLevelSelect.innerHTML = "";

    if (Level === "Elementary") {
        for (let i = 1; i <= 6; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (Level === "High School") {
        for (let i = 7; i <= 12; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (Level === "College") {
        for (let i = 1; i <= 4; i++) {
            const suffix = getYearSuffix(i);
            const option = document.createElement("option");
            option.value = `${i}${suffix} Year`;
            option.text = `${i}${suffix} Year`;
            yearLevelSelect.add(option);
        }
    }
}

// Year level for Edit
function updateEditYearLevel() {
    const Level = document.getElementById("edit_teach_level").value;
    const yearLevelSelect = document.getElementById("edit_year_level");
    yearLevelSelect.innerHTML = ""; 

    if (Level === "Elementary") {
        for (let i = 1; i <= 6; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (Level === "High School") {
        for (let i = 7; i <= 12; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (Level === "College") {
        for (let i = 1; i <= 4; i++) {
            const suffix = getYearSuffix(i);
            const option = document.createElement("option");
            option.value = `${i}${suffix} Year`;
            option.text = `${i}${suffix} Year`;
            yearLevelSelect.add(option);
        }
    }
}

function getYearSuffix(year) {
    if (year === 1) return "st";
    if (year === 2) return "nd";
    if (year === 3) return "rd";
    return "th";
}