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