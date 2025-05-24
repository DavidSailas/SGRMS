document.addEventListener('DOMContentLoaded', function () {
    // VIEW PARENT MODAL CODE (unchanged)
    const modal = document.getElementById('parentModal');
    const closeBtn = document.getElementById('closeParentModal');

    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function () {
            const parentId = this.getAttribute('data-id');

            fetch(`../../../app/Controllers/Head/ParentController/getparent.php?id=${parentId}`
                || `../../../app/Controllers/Counsel/ParentController/getparent.php?id=${parentId}`
            )
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalName').textContent = data.name || '';
                    document.getElementById('modalRelationship').textContent = data.relationship || '';
                    document.getElementById('modalContact').textContent = data.contact || '';
                    document.getElementById('modalEmail').textContent = data.email || '';
                    document.getElementById('modalUsername').textContent = data.username || '';
                    document.getElementById('modalStatus').innerHTML = data.account_status || '';

                    const childList = document.getElementById('modalChildren');
                    childList.innerHTML = '';
                    if (data.children && data.children.length > 0) {
                        data.children.forEach(child => {
                            childList.innerHTML += `<li>${child}</li>`;
                        });
                    } else {
                        childList.innerHTML = '<li>No children found</li>';
                    }

                    modal.style.display = 'flex';
                })
                .catch(error => console.error('Error fetching parent data:', error));
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // -------------------
    // EDIT PARENT MODAL JS
    // -------------------
    const editModal = document.getElementById('editParentModal');
    const closeEditBtn = document.getElementById('closeEditModal');
    const editForm = document.getElementById('editParentForm');

    // Open edit modal and load parent data
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const parentId = this.getAttribute('data-id');

            fetch(`../../../app/Controllers/Head/ParentController/getparent.php?id=${parentId}`
                || `../../../app/Controllers/Counsel/ParentController/getparent.php?id=${parentId}`
            )
                .then(response => response.json())
                .then(data => {
                    // Fill form inputs with current data
                    document.getElementById('editParentId').value = parentId;
                    document.getElementById('editName').value = data.name || '';
                    document.getElementById('editRelationship').value = data.relationship || '';
                    document.getElementById('editContact').value = data.contact || '';
                    document.getElementById('editEmail').value = data.email || '';
                    document.getElementById('editUsername').value = data.username || '';

                    editModal.style.display = 'flex';
                })
                .catch(error => console.error('Error fetching parent data for edit:', error));
        });
    });

    closeEditBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    });

    // Submit edit form - update parent and account
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const parentId = document.getElementById('editParentId').value;
        const name = document.getElementById('editName').value.trim();
        const relationship = document.getElementById('editRelationship').value.trim();
        const contact = document.getElementById('editContact').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const username = document.getElementById('editUsername').value.trim();

        // Prepare data to send
        const formData = new FormData();
        formData.append('id', parentId);
        formData.append('name', name);
        formData.append('relationship', relationship);
        formData.append('contact', contact);
        formData.append('email', email);
        formData.append('username', username);

        fetch(`../../../app/Controllers/Head/ParentController/editparent.php`
            || `../../../app/Controllers/Counsel/ParentController/editparent.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Parent and account updated successfully.');
                    editModal.style.display = 'none';
                    // Optionally, reload or update the table row here
                    location.reload(); // simple reload to reflect changes
                } else {
                    alert('Update failed: ' + (result.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating parent:', error);
                alert('An error occurred while updating.');
            });
    });

    const archiveButtons = document.querySelectorAll(".btn-delete");
    const archiveModal = document.getElementById("archiveModal");
    const closeArchiveModal = document.getElementById("closeArchiveModal");
    const cancelArchiveBtn = document.getElementById("cancelArchiveBtn");
    const confirmArchiveBtn = document.getElementById("confirmArchiveBtn");

    let selectedParentId = null;

    archiveButtons.forEach(button => {
        button.addEventListener("click", function () {
            selectedParentId = this.dataset.id;
            archiveModal.style.display = "flex";
        });
    });

    closeArchiveModal.onclick = cancelArchiveBtn.onclick = function () {
        archiveModal.style.display = "none";
        selectedParentId = null;
    };

    confirmArchiveBtn.onclick = function () {
        if (!selectedParentId) return;

        fetch("../../../app/Controllers/Head/ParentController/archiveparent.php" 
            || "../../../app/Controllers/Counsel/ParentController/archiveparent.php" , {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ parent_id: selectedParentId })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Parent archived successfully.");
                archiveModal.style.display = "none";
                location.reload();
            } else {
                alert("Archive failed: " + (result.error || "Unknown error"));
            }
        })
        .catch(error => {
            console.error("Error archiving parent:", error);
            alert("An error occurred.");
        });
    };
});
