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

    // View Case Modal
    window.openViewCaseModal = function(caseId) {
        const viewModal = document.getElementById("viewCaseModal");
        const viewContent = document.getElementById("viewCaseContent");
        viewContent.innerHTML = "<p>Loading...</p>";
        viewModal.style.display = "block";
        fetch(`../../../app/Controllers/Head/CaseController/viewcase.php?id=${caseId}`)
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
                            <a href="../../../app/Controllers/Head/CaseController/export_case.php?id=${data.case_id}" target="_blank" class="btn btn-export" style="margin-right:10px;">Export to PDF</a>
                            <a href="../../../app/Controllers/Head/CaseController/export_cases_excel.php?id=${data.case_id}" target="_blank" class="btn btn-export">Export to Excel</a>
                        </div>
                    `;
                } else {
                    viewContent.innerHTML = `<span class="close" onclick="closeViewCaseModal()">&times;</span><p>${data.error || "No data found."}</p>`;
                }
            })
            .catch(err => {
                viewContent.innerHTML = `<span class="close" onclick="closeViewCaseModal()">&times;</span><p>Error loading case details.</p>`;
            });
    };

    window.closeViewCaseModal = function() {
        document.getElementById("viewCaseModal").style.display = "none";
    };

    // Close view modal when clicking outside
    window.addEventListener("click", function (event) {
        const viewModal = document.getElementById("viewCaseModal");
        if (event.target === viewModal) {
            viewModal.style.display = "none";
        }
    });

    // Notification Dropdown
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    bell.addEventListener('click', function(e) {
        e.preventDefault();
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target) && event.target !== bell) {
            dropdown.style.display = 'none';
        }
    });

    // Archive Case Modal
    let archiveCaseId = null;

    window.openArchiveModal = function(caseId) {
        archiveCaseId = caseId;
        document.getElementById('archiveModal').style.display = 'block';
    }

    document.getElementById('closeArchiveModalBtn').onclick = function() {
        document.getElementById('archiveModal').style.display = 'none';
        archiveCaseId = null;
    };
    document.getElementById('cancelArchiveBtn').onclick = function() {
        document.getElementById('archiveModal').style.display = 'none';
        archiveCaseId = null;
    };
    document.getElementById('confirmArchiveBtn').onclick = function() {
        if (archiveCaseId) {
            window.location.href = "../../../app/Controllers/Head/CaseController/archive.php?id=" + archiveCaseId;
        }
    };
    window.onclick = function(event) {
        const modal = document.getElementById('archiveModal');
        if (event.target === modal) {
            modal.style.display = 'none';
            archiveCaseId = null;
        }
    };

    // Student Search
    document.getElementById('student_search').addEventListener('input', function() {
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
        // Show the student ID above the input
        document.getElementById('selectedStudentId').textContent = found && idNum ? "Student ID: " + idNum : "";
        if (!found) {
            document.getElementById('student_id').value = '';
            document.getElementById('selectedStudentId').textContent = "";
        }
    });
});