function openFormModal() {
    document.getElementById("formModal").style.display = "flex";
}

function closeFormModal() {
    document.getElementById("formModal").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    const profileBoxes = document.querySelectorAll(".view-child");
    const modal = document.getElementById("viewChildModal");
    const closeBtn = modal.querySelector(".close-modal");
    const detailsContainer = document.getElementById("studentDetails");

    profileBoxes.forEach(box => {
        box.addEventListener("click", () => {
            const studentId = box.getAttribute("data-student-id");

            fetch(`../../../app/Controllers/Parent/ChildController/getchild.php?id=${studentId}`)
                .then(response => response.text())
                .then(data => {
                    detailsContainer.innerHTML = data;
                    modal.style.display = "flex"; 
                });
        });
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target == modal) {
            modal.style.display = "none";
        }
    });
});
