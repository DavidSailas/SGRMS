document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const filterSelect = document.getElementById('filter_educ');
    const tableBody = document.getElementById('studentTableBody');

    function updateTable() {
        const search = searchInput.value.trim();
        const filter = filterSelect.value; 

        // Corrected path to match your actual file location
        const url = `../../../app/Controllers/Head/StudentController/searchstud.php?search=${encodeURIComponent(search)}&filter_educ=${encodeURIComponent(filter)}`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
            })
            .catch(error => {
                console.error('Search failed:', error);
            });
    }

    searchInput.addEventListener('input', updateTable);
    filterSelect.addEventListener('change', updateTable);
});
