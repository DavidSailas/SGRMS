document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('parentSearch');
    const table = document.getElementById('parentTable');
    const tbody = document.getElementById('parentTableBody');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        let anyVisible = false;
        Array.from(tbody.rows).forEach(row => {
            const nameCell = row.cells[0];
            if (!nameCell) return;
            const name = nameCell.textContent.toLowerCase();
            const show = name.includes(filter) || filter === '';
            row.style.display = show ? '' : 'none';
            if (show) anyVisible = true;
        });
   
        const noDataRow = tbody.querySelector('tr td[colspan]');
        if (noDataRow) {
            noDataRow.parentElement.style.display = anyVisible ? 'none' : '';
        }

        paginateTable('parentTable', 'pagination-parent');
    });
});