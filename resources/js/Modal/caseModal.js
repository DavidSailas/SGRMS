document.addEventListener("DOMContentLoaded", function () {
    // Add Case Modal
    const openBtn = document.getElementById("openModalBtn");
    const addModal = document.getElementById("addCaseModal");
    const closeBtn = document.getElementById("closeModalBtn");

    if (openBtn && addModal && closeBtn) {
        openBtn.addEventListener("click", function () {
            addModal.style.display = "block";
        });

        closeBtn.addEventListener("click", function () {
            addModal.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target === addModal) {
                addModal.style.display = "none";
            }
        });
    }

    // Edit Case Modal
    window.openEditCaseModal = function(caseId) {
        const modal = document.getElementById('editCaseModal');
        if (!modal) return;
        modal.style.display = 'block';

        fetch(`../../../app/Controllers/Head/CaseController/fetchcase.php?case_id=${caseId}`
            || `../../../app/Controllers/Counsel/CaseController/fetchcase.php?case_id=${caseId}`
        )
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('edit_case_id').value = data.case_id || '';
                    document.getElementById('edit_case_type').value = data.case_type || '';
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_reported_by').value = data.reported_by || '';
                    document.getElementById('edit_referred_by').value = data.referred_by || '';
                    document.getElementById('edit_referral_date').value = data.referral_date || '';
                    document.getElementById('edit_reason_for_referral').value = data.reason_for_referral || '';
                    document.getElementById('edit_presenting_problem').value = data.presenting_problem || '';
                    document.getElementById('edit_observe_behavior').value = data.observe_behavior || '';
                    document.getElementById('edit_family_background').value = data.family_background || '';
                    document.getElementById('edit_academic_history').value = data.academic_history || '';
                    document.getElementById('edit_social_relationships').value = data.social_relationships || '';
                    document.getElementById('edit_medical_history').value = data.medical_history || '';
                    document.getElementById('edit_counselor_assessment').value = data.counselor_assessment || '';
                    document.getElementById('edit_recommendations').value = data.recommendations || '';
                    document.getElementById('edit_follow_up_plan').value = data.follow_up_plan || '';
                    document.getElementById('edit_status').value = data.status || '';
                } else {
                    alert('Failed to load case data.');
                }
            })
            .catch(error => {
                console.error('Error fetching case data:', error);
                alert('Error fetching case data.');
            });
    };

    const closeEditBtn = document.getElementById('closeEditModalBtn');
    if (closeEditBtn) {
        closeEditBtn.onclick = function() {
            const modal = document.getElementById('editCaseModal');
            if(modal) modal.style.display = 'none';
        };
    }

    // View Case Modal
    window.openViewCaseModal = function(caseId) {
        const viewModal = document.getElementById("viewCaseModal");
        const viewContent = document.getElementById("viewCaseContent");
        if (!viewModal || !viewContent) return;

        viewContent.innerHTML = "<p>Loading...</p>";
        viewModal.style.display = "block";

        fetch(`../../../app/Controllers/Head/CaseController/viewcase.php?id=${caseId}`
            || `../../../app/Controllers/Counsel/CaseController/viewcase.php?id=${caseId}`
        )
            .then(response => response.json())
            .then(data => {
                if (data && !data.error) {
                    viewContent.innerHTML = `
                        <span class="close" onclick="closeViewCaseModal()">&times;</span>
                        <h2>Case Details</h2>
                        <div><strong>Case Type:</strong> ${data.case_type}</div>
                        <div><strong>Student Name:</strong> ${data.lname}, ${data.fname}</div>
                        <div><strong>Description:</strong> ${data.description}</div>
                        <div><strong>Reported By:</strong> ${data.reported_by}</div>
                        <div><strong>Filed Date:</strong> ${data.filed_date}</div>
                        <div><strong>Status:</strong> ${data.status}</div>
                        <div style="margin-top:16px;">
                            <a href="../../../app/Controllers/Head/CaseController/export_case.php?id=${data.case_id}
                            || ../../../app/Controllers/Counsel/CaseController/export_case.php?id=${data.case_id}"
                            target="_blank" class="btn btn-export" style="margin-right:10px;">Export to PDF</a>

                            <a href="../../../app/Controllers/Head/CaseController/export_cases_excel.php?id=${data.case_id}
                            || ../../../app/Controllers/Counsel/CaseController/export_cases_excel.php?id=${data.case_id}" 
                            target="_blank" class="btn btn-export">Export to Excel</a>
                        </div>
                    `;
                } else {
                    viewContent.innerHTML = `<span class="close" onclick="closeViewCaseModal()">&times;</span><p>${data.error || "No data found."}</p>`;
                }
            })
            .catch(() => {
                viewContent.innerHTML = `<span class="close" onclick="closeViewCaseModal()">&times;</span><p>Error loading case details.</p>`;
            });
    };

    window.closeViewCaseModal = function() {
        const viewModal = document.getElementById("viewCaseModal");
        if (viewModal) viewModal.style.display = "none";
    };

    // Archive Case Modal
    let archiveCaseId = null;

    window.openArchiveModal = function(caseId) {
        archiveCaseId = caseId;
        const archiveModal = document.getElementById('archiveModal');
        if(archiveModal) archiveModal.style.display = 'block';
    }

    const closeArchiveModalBtn = document.getElementById('closeArchiveModalBtn');
    if(closeArchiveModalBtn) {
        closeArchiveModalBtn.onclick = closeArchiveModal;
    }
    const cancelArchiveBtn = document.getElementById('cancelArchiveBtn');
    if(cancelArchiveBtn) {
        cancelArchiveBtn.onclick = closeArchiveModal;
    }
    const confirmArchiveBtn = document.getElementById('confirmArchiveBtn');
    if(confirmArchiveBtn) {
        confirmArchiveBtn.onclick = function() {
            if (archiveCaseId) {
                window.location.href = "../../../app/Controllers/Head/CaseController/archive.php?id=" + archiveCaseId
                || "../../../app/Controllers/Counsel/CaseController/archive.php?id=" + archiveCaseId;
            }
        };
    }

    function closeArchiveModal() {
        const archiveModal = document.getElementById('archiveModal');
        if (archiveModal) archiveModal.style.display = 'none';
        archiveCaseId = null;
    }

    // Close modals when clicking outside (single handler)
    window.addEventListener('click', function(event) {
        // Add Modal
        if (addModal && event.target === addModal) {
            addModal.style.display = 'none';
        }
        // Edit Modal
        const editModal = document.getElementById('editCaseModal');
        if (editModal && event.target === editModal) {
            editModal.style.display = 'none';
        }
        // View Modal
        const viewModal = document.getElementById('viewCaseModal');
        if (viewModal && event.target === viewModal) {
            viewModal.style.display = 'none';
        }
        // Archive Modal
        const archiveModal = document.getElementById('archiveModal');
        if (archiveModal && event.target === archiveModal) {
            archiveModal.style.display = 'none';
            archiveCaseId = null;
        }
    });

    // Notification Dropdown
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    if(bell && dropdown) {
        bell.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target) && event.target !== bell) {
                dropdown.style.display = 'none';
            }
        });
    }

    // Student Search
    const studentSearch = document.getElementById('student_search');
    if(studentSearch) {
        studentSearch.addEventListener('input', function() {
            const input = this.value;
            const options = document.querySelectorAll('#student_list option');
            let found = false;
            let idNum = '';
            options.forEach(option => {
                if (option.value === input) {
                    document.getElementById('student_id').value = option.getAttribute('data-id');
                    idNum = option.getAttribute('data-idnum');
                    found = true;
                }
            });
            document.getElementById('selectedStudentId').textContent = found && idNum ? "Student ID: " + idNum : "";
            if (!found) {
                document.getElementById('student_id').value = '';
                document.getElementById('selectedStudentId').textContent = "";
            }
        });
    }
});
