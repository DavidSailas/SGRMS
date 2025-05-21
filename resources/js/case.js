// case.js

function filterCases(level) {
    let rows = document.querySelectorAll("#caseTable tbody tr:not(#noRecordsRow)");
    let anyVisible = false;

    rows.forEach(row => {
        let caseStatus = row.cells[3].textContent.trim().toLowerCase();
        let academicLevel = row.cells[1].textContent.trim().toLowerCase();
        let show = false;

        if (level === "all") {
            show = (caseStatus !== "archived");
        } else if (level === "pending") {
            show = (caseStatus === "pending");
        } else if (level === "archived") {
            show = (caseStatus === "archived");
        } else {
            // Show all cases for the selected academic level, except archived
            show = (academicLevel === level && caseStatus !== "archived");
        }

        row.style.display = show ? "" : "none";
        if (show) anyVisible = true;
    });

    document.getElementById("noRecordsRow").style.display = anyVisible ? "none" : "";

    // Tab highlight
    let tabId = level === "high school" ? "highschoolTab" : level + "Tab";
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    let activeTab = document.getElementById(tabId);
    if (activeTab) activeTab.classList.add('active');

    paginateTable();
}

function searchCases() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#caseTable tbody tr:not(#noRecordsRow)");
    let anyVisible = false;

    rows.forEach(row => {
        let caseID = row.cells[0].textContent.toLowerCase();
        let caseType = row.cells[2].textContent.toLowerCase();
        let caseStatus = row.cells[3].textContent.trim().toLowerCase();

        let show = (caseStatus !== "archived") &&
                   (caseID.includes(input) || caseType.includes(input));
        row.style.display = show ? "" : "none";
        if (show) anyVisible = true;
    });

    document.getElementById("noRecordsRow").style.display = anyVisible ? "none" : "";

    paginateTable();
}

document.addEventListener("DOMContentLoaded", () => {
    filterCases('all');
});
