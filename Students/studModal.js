let studentIdToDelete = null; 

//edit student details
function editStudent(studentId) {
    openModal("Edit Student", studentId);
}

function openModal(title, studentId = null) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('studentModal').style.display = 'block';
    
    if (studentId) {
        fetch(`fetchstud.php?s_id=${studentId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
 
                    document.getElementById('s_id').value = data.s_id;
                    document.getElementById('lname').value = data.lname;
                    document.getElementById('fname').value = data.fname;
                    document.getElementById('mname').value = data.mname;
                    document.getElementById('bod').value = data.bod;
                    document.getElementById('gender').value = data.gender;
                    document.getElementById('address').value = data.address;
                    document.getElementById('mobile_num').value = data.mobile_num;
                    document.getElementById('email').value = data.email;
                    document.getElementById('educ_level').value = data.educ_level;
                    updateYearLevel(); 
                    document.getElementById('year_level').value = data.year_level;
                    document.getElementById('section').value = data.section;

                    const studentImage = document.getElementById('studentImage');
                    studentImage.src = data.s_image ? data.s_image : '/SGRMS/profile/circle-user.png'; 
                    studentImage.style.display = 'block'; 

                    document.getElementById('studentForm').action = "editstud.php";
                }
            })
            .catch(error => console.error('Error fetching student data:', error));
    } else {
        document.getElementById('studentForm').action = "addstud.php";
        document.getElementById('studentImage').style.display = 'none';
    }
}

//view student details
function viewStudent(studentId) {
    document.getElementById('viewModalTitle').innerText = "View Student";
    document.getElementById('viewStudentModal').style.display = 'block';

    fetch(`viewstud.php?s_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('studentName').innerText = data.name;
                document.getElementById('studentAge').innerText = data.age;
                document.getElementById('studentDOB').innerText = data.dob;
                document.getElementById('studentSex').innerText = data.sex;
                document.getElementById('studentAddress').innerText = data.address;
                document.getElementById('studentMobile').innerText = data.mobile_num;
                document.getElementById('studentEmail').innerText = data.email;
                document.getElementById('studentEducLevel').innerText = data.educ_level;
                document.getElementById('studentYearLevel').innerText = data.year_level;
                document.getElementById('studentSection').innerText = data.section;

                const viewStudentImage = document.getElementById('viewStudentImage');
                viewStudentImage.src = data.s_image ? data.s_image : '/SGRMS/profile/circle-user.png'; 
                viewStudentImage.style.display = 'block';
            }
        })
        .catch(error => console.error('Error fetching student data:', error));
}

//delete confirm
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

function closeModal() {
    document.getElementById('studentModal').style.display = 'none';
    document.getElementById('studentForm').reset(); 
}

function closeViewModal() {
    document.getElementById('viewStudentModal').style.display = 'none';
}

// Year level
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

function getYearSuffix(year) {
    if (year === 1) return "st";
    if (year === 2) return "nd";
    if (year === 3) return "rd";
    return "th";
}

// Close
window.onclick = function(event) {
    const studentModal = document.getElementById('studentModal');
    const viewStudentModal = document.getElementById('viewStudentModal');
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    
    if (event.target == studentModal) {
        closeModal();
    } else if (event.target == viewStudentModal) {
        closeViewModal();
    } else if (event.target == deleteConfirmationModal) {
        closeDeleteConfirmationModal();
    }
}