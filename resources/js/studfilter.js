studfilter.js
function filterStudents(filter) {
    const rows = document.querySelectorAll("#studentTableBody tr");
    rows.forEach(row => {
        const statusText = row.querySelector('.status-text')?.textContent.trim().toLowerCase() || '';
        const educLevel = row.children[4].textContent.trim().toLowerCase();
        let showRow = false;

        if (filter === 'all') {
            showRow = (statusText === 'active');
        } else if (['college', 'high school', 'elementary'].includes(filter)) {
            showRow = (educLevel === filter && statusText === 'active');
        } else if (['inactive', 'archived'].includes(filter)) {
            showRow = (statusText === filter);
        }

        row.style.display = showRow ? "" : "none";
    });

    // Update active tab
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    const selectedTab = document.getElementById(filter + 'Tab');
    if (selectedTab) selectedTab.classList.add('active');

    // Call pagination function
    paginateTable('studentTable', 'pagination-student');
}