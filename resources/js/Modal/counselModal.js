function openFormModal() {
    document.getElementById('formModal').style.display = "block";
}

function closeFormModal() {
    document.getElementById('formModal').style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('formModal');
    if (event.target == modal) {
        closeFormModal();
    }
}

function openViewCounselModal(c_id) {
    document.getElementById('viewCounselModal').style.display = "block";
    fetch(`../../../app/Controllers/Head/CounselorController/viewcounsel.php?c_id=${c_id}`)
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                document.getElementById('view_c_image').src = data.c_image ? data.c_image : '../../Public/user.img/people.png';
                document.getElementById('view_c_name').textContent = `${data.lname}, ${data.fname} ${data.mname}`;
                document.getElementById('view_c_email').textContent = data.email;
                document.getElementById('view_c_contact').textContent = data.contact_num;
                document.getElementById('view_c_level').textContent = data.c_level;
                document.getElementById('view_c_username').textContent = data.username;
                // Set the edit button to open the edit modal for this counselor
                document.getElementById('editCounselBtn').onclick = function() {
                    closeViewCounselModal();
                    openEditCounselModal(data.c_id);
                };
            } else {
                document.getElementById('viewCounselContent').innerHTML = "<p style='color:red;'>Counselor not found.</p>";
            }
        })
        .catch(() => {
            document.getElementById('viewCounselContent').innerHTML = "<p style='color:red;'>Error loading details.</p>";
        });
}

function closeViewCounselModal() {
    document.getElementById('viewCounselModal').style.display = "none";
}

function openEditCounselModal(c_id) {
    document.getElementById('editCounselModal').style.display = "block";
    fetch(`../../../app/Controllers/Head/CounselorController/viewcounsel.php?c_id=${c_id}`)
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                document.getElementById('edit_c_id').value = data.c_id;
                document.getElementById('edit_lname').value = data.lname;
                document.getElementById('edit_fname').value = data.fname;
                document.getElementById('edit_mname').value = data.mname;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_contact_num').value = data.contact_num;
                document.getElementById('edit_c_level').value = data.c_level;
            }
        });
}

function closeEditCounselModal() {
    document.getElementById('editCounselModal').style.display = "none";
}

document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.getElementById('editCounselForm');
    if (editForm) {
        editForm.onsubmit = function (e) {
            e.preventDefault();
            const formData = new FormData(editForm);
            fetch('../../../app/Controllers/Head/CounselorController/editcounsel.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeEditCounselModal();
                    location.reload(); // Refresh to show updated info
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert('An error occurred while updating.'));
        };
    }
});