let studentIdToDelete = null; 

function openAddModal() {
    document.getElementById("addStudentModal").style.display = "block";
    fetchStudentId(); // Fetch ID when opening the modal
}

// Open Edit Student Modal
function openEditModal(studentId) {
    fetch(`fetchstud.php?s_id=${studentId}`)
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
                    document.getElementById('edit_program').value = data.program; // Set program value
                    document.getElementById('edit_programField').style.display = 'block'; // Show program field
                    document.getElementById('edit_sectionField').style.display = 'none'; // Hide section field
                } else {
                    document.getElementById('edit_section').value = data.section; // Set section value
                    document.getElementById('edit_programField').style.display = 'none'; // Hide program field
                    document.getElementById('edit_sectionField').style.display = 'block'; // Show section field
                }

                const editStudentImage = document.getElementById('edit_studentImage');
                editStudentImage.src = data.s_image ? data.s_image : '/SGRMS/profile/circle-user.png'; 
                editStudentImage.style.display = 'block'; 

                document.getElementById("editStudentModal").style.display = "block";
            } else {
                console.error(data.error); // Log the error if student not found
                alert("Error: " + data.error); // Alert the user
            }
        })
        .catch(error => console.error('Error fetching student data:', error));
}

// View student details
function viewStudent(studentId) {
    document.getElementById('viewModalTitle').innerText = "View Student";
    document.getElementById('viewStudentModal').style.display = 'block';

    fetch(`viewstud.php?s_id=${studentId}`)
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

                const viewStudentImage = document.getElementById('viewStudentImage');
                viewStudentImage.src = data.s_image ? data.s_image : '/SGRMS/profile/circle-user.png'; 
                viewStudentImage.style.display = 'block';
            }
        })
        .catch(error => console.error('Error fetching student data:', error));
}

// Delete confirm
function openDeleteConfirmationModal(studentId) {
    studentIdToDelete = studentId; 
    document.getElementById('deleteConfirmationModal').style.display = 'block';
}

function closeDeleteConfirmationModal() {
    document.getElementById('deleteConfirmationModal').style.display = 'none';
}

document.getElementById('confirmDeleteButton').onclick = function() {
    if (studentIdToDelete) {
        window.location.href = `deletestud.php?s_id=${studentIdToDelete}`;
    }
};

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