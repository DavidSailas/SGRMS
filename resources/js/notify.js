// notify.js

document.addEventListener("DOMContentLoaded", () => {
    const badge = document.querySelector(".notification .num");
    const dropdownList = document.querySelector("#notificationDropdown ul");
    const seeMoreWrapper = document.getElementById("seeMoreWrapper");
    const seeMoreLink = document.getElementById("seeMoreLink");
    const notificationBell = document.getElementById("notificationBell");

    let notifCount = parseInt(localStorage.getItem("notifCount")) || 0;
    let notifMessages = JSON.parse(localStorage.getItem("notifMessages")) || [];

    badge.textContent = notifCount > 0 ? notifCount : "";

    // Limit to 5 for dropdown view
    dropdownList.innerHTML = "";
    const displayCount = Math.min(notifMessages.length, 5);
    for (let i = 0; i < displayCount; i++) {
        const li = document.createElement("li");
        li.textContent = notifMessages[i];
        dropdownList.appendChild(li);
    }

    seeMoreWrapper.style.display = notifMessages.length > 5 ? "block" : "none";

    seeMoreLink.addEventListener("click", (e) => {
        e.preventDefault();
        openNotificationModal();
    });

    // Toggle dropdown on bell click
    notificationBell.addEventListener("click", function(e) {
        e.preventDefault();
        toggleNotifications();
    });

    if (window.newCaseAdded) {
        addNotification("✅ New Student has been successfully added.");
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }
});

function addNotification(message) {
    const badge = document.querySelector(".notification .num");
    const dropdownList = document.querySelector("#notificationDropdown ul");
    const seeMoreWrapper = document.getElementById("seeMoreWrapper");

    let notifCount = parseInt(localStorage.getItem("notifCount")) || 0;
    let notifMessages = JSON.parse(localStorage.getItem("notifMessages")) || [];

    notifCount += 1;
    notifMessages.unshift(message);
    localStorage.setItem("notifCount", notifCount);
    localStorage.setItem("notifMessages", JSON.stringify(notifMessages));

    badge.textContent = notifCount;

    dropdownList.innerHTML = "";
    const displayCount = Math.min(notifMessages.length, 5);
    for (let i = 0; i < displayCount; i++) {
        const li = document.createElement("li");
        li.textContent = notifMessages[i];
        dropdownList.appendChild(li);
    }

    seeMoreWrapper.style.display = notifMessages.length > 5 ? "block" : "none";
}

function toggleNotifications() {
    const dropdown = document.getElementById("notificationDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

    if (dropdown.style.display === "block") {
        const badge = document.querySelector(".notification .num");
        badge.textContent = "";
        localStorage.setItem("notifCount", "0");
    }
}

document.addEventListener("click", function (event) {
    const notificationBell = document.getElementById('notificationBell');
    const dropdown = document.getElementById("notificationDropdown");

    if (!notificationBell.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = "none";
    }
});

function openNotificationModal() {
    const notifMessages = JSON.parse(localStorage.getItem("notifMessages")) || [];
    const modalList = document.getElementById("modalNotificationList");
    const modal = document.getElementById("notificationModal");

    modalList.innerHTML = "";
    notifMessages.forEach(msg => {
        const li = document.createElement("li");
        li.textContent = msg;
        modalList.appendChild(li);
    });

    modal.style.display = "block";
}

function closeModal() {
    document.getElementById("notificationModal").style.display = "none";
}

function updateNotifCount() {
    fetch('/SGRMS/app/Controllers/Head/NotifyController/get_notif.php')
        .then(res => res.json())
        .then(data => {
            const badge = document.querySelector(".notification .num");
            if (badge) {
                badge.textContent = data.count > 0 ? data.count : '';
                badge.style.display = data.count > 0 ? '' : 'none';
            }
        });
}

document.addEventListener("DOMContentLoaded", updateNotifCount);
