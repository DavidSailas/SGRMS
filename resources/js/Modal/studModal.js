let studentIdToDelete = null; 

function openAddModal() {
    document.getElementById("addStudentModal").style.display = "block";
    fetchStudentId(); // Fetch ID when opening the modal
}

// Open Edit Student Modal
function openEditModal(studentId) {
    const modal = document.getElementById("editStudentModal");
    if (!modal) {
        console.error("Edit modal not found");
        return;
    }
    modal.style.display = "block"; // Show modal immediately

    fetch(`../../../app/Controllers/Head/StudentController/fetchstud.php?s_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                // Populate the form fields with the fetched data
                document.getElementById('edit_s_id').value = data.s_id;
                document.getElementById('edit_id_num').value = data.id_num;
                document.getElementById('edit_id_num_display').textContent = data.id_num;
                document.getElementById('edit_prefix').value = data.prefix;
                document.getElementById('edit_lname').value = data.lname;
                document.getElementById('edit_fname').value = data.fname;
                document.getElementById('edit_mname').value = data.mname;
                document.getElementById('edit_bod').value = data.bod;
                document.getElementById('edit_gender').value = data.gender;
                document.getElementById('edit_address').value = data.address;
                document.getElementById('edit_mobile_num').value = data.mobile_num;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_educ_level').value = data.educ_level;

                // Update the year level based on the educational level
                updateEditYearLevel(); 
                document.getElementById('edit_year_level').value = data.year_level;

                // Set the section and program fields based on the educational level
                if (data.educ_level === 'College') {
                    document.getElementById('edit_program').value = data.program; 
                    document.getElementById('edit_programField').style.display = 'block'; 
                    document.getElementById('edit_sectionField').style.display = 'none'; 
                } else {
                    document.getElementById('edit_section').value = data.section; 
                    document.getElementById('edit_programField').style.display = 'none'; 
                    document.getElementById('edit_sectionField').style.display = 'block';
                }

                document.getElementById('edit_previous_school').value = data.previous_school;
                document.getElementById('edit_last_year_school').value = data.last_year_school;

                const editStudentImage = document.getElementById('edit_studentImage');
                editStudentImage.src = data.s_image ? data.s_image : '../../Public/stud.img/circle-user.png'; 
                editStudentImage.style.display = 'block'; 

                // Populate guardian information
                document.getElementById('edit_guardian_name').value = data.guardian_name || '';
                document.getElementById('edit_relationship').value = data.relationship || '';
                document.getElementById('edit_guardian_contact').value = data.guardian_contact || '';
                document.getElementById('edit_guardian_email').value = data.guardian_email || '';
            } else {
                alert("Error: " + data.error);
            }
        })
        .catch(error => console.error('Error fetching student data:', error));
}

// View student details
function viewStudent(studentId) {
    document.getElementById('viewModalTitle').innerText = "View Student";
    document.getElementById('viewStudentModal').style.display = 'block';

    fetch(`../../../app/Controllers/Head/StudentController/viewstud.php?s_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('studentId').innerText = data.id_num;
                document.getElementById('studentName').innerText = data.name;
                document.getElementById('studentAge').innerText = data.age;
                document.getElementById('studentDOB').innerText = data.dob;
                document.getElementById('studentSex').innerText = data.sex;
                document.getElementById('studentAddress').innerText = data.address;
                document.getElementById('studentMobile').innerText = data.mobile_num;
                document.getElementById('studentEmail').innerText = data.email;
                document.getElementById('studentEducLevel').innerText = data.educ_level;
                document.getElementById('studentYearLevel').innerText = data.year_level;
                document.getElementById('studentSectionProgram').innerText = data.section_program;

                // Add these lines for guardian info:
                document.getElementById('viewGuardianName').innerText = data.guardian_name || '';
                document.getElementById('viewRelationship').innerText = data.relationship || '';
                document.getElementById('viewGuardianContact').innerText = data.guardian_contact || '';
                document.getElementById('viewGuardianEmail').innerText = data.guardian_email || '';

                const viewStudentImage = document.getElementById('viewStudentImage');
                viewStudentImage.src = data.s_image ? data.s_image : '../../Public/stud.img/circle-user.png'; 
                viewStudentImage.style.display = 'block';
            }
        })
        .catch(error => console.error('Error fetching student data:', error));
}

// Delete confirm
function openDeleteConfirmationModal(studentId) {
    studentIdToDelete = studentId; // Store the student ID to delete
    console.log("Student ID to delete:", studentIdToDelete); // Log the ID
    document.getElementById("deleteConfirmationModal").style.display = "block"; // Show the modal
}

function closeDeleteConfirmationModal() {
    document.getElementById("deleteConfirmationModal").style.display = "none"; // Hide the modal
}
function confirmDelete() {
    if (studentIdToDelete) {
        // Send a request to delete the student
        fetch(`../../../app/Controllers/Head/StudentController/deletestud.php?s_id=${studentIdToDelete}`, {
            method: 'DELETE' // Use DELETE method
        })
        .then(response => {
            if (response.ok) {
                // Successfully deleted
                alert("Student deleted successfully.");
                location.reload(); // Reload the page to update the student list
            } else {
                alert("Error deleting student.");
            }
        })
        .catch(error => console.error('Error:', error));
    }
    closeDeleteConfirmationModal(); // Close the modal
}

// Close Add Modal
function closeAddModal() {
    document.getElementById("addStudentModal").style.display = "none";
    document.getElementById('addStudentForm').reset(); // Reset the form fields
}

// Close Edit Modal
function closeEditModal() {
    document.getElementById("editStudentModal").style.display = "none";
    document.getElementById('editStudentForm').reset(); // Reset the form fields
}

// Close View Modal
function closeViewModal() {
    document.getElementById('viewStudentModal').style.display = 'none';
}

// Year level for Add
function updateYearLevel() {
    const educLevel = document.getElementById("educ_level").value;
    const yearLevelSelect = document.getElementById("year_level");
    yearLevelSelect.innerHTML = "";

    if (educLevel === "Elementary") {
        for (let i = 1; i <= 6; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (educLevel === "High School") {
        for (let i = 7; i <= 12; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (educLevel === "College") {
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
    const educLevel = document.getElementById("edit_educ_level").value;
    const yearLevelSelect = document.getElementById("edit_year_level");
    yearLevelSelect.innerHTML = ""; 

    if (educLevel === "Elementary") {
        for (let i = 1; i <= 6; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (educLevel === "High School") {
        for (let i = 7; i <= 12; i++) {
            const option = document.createElement("option");
            option.value = `Grade ${i}`;
            option.text = `Grade ${i}`;
            yearLevelSelect.add(option);
        }
    } else if (educLevel === "College") {
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

// Close modals when clicking outside
window.onclick = function(event) {
    const addStudentModal = document.getElementById('addStudentModal');
    const editStudentModal = document.getElementById('editStudentModal');
    const viewStudentModal = document.getElementById('viewStudentModal');
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    
    if (event.target == addStudentModal) {
        closeAddModal();
    } else if (event.target == editStudentModal) {
        closeEditModal();
    } else if (event.target == viewStudentModal) {
        closeViewModal();
    } else if (event.target == deleteConfirmationModal) {
        closeDeleteConfirmationModal();
    }
}