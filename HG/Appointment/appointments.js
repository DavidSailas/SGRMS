const appointments = [];

let currentRole = 'requester';

document.addEventListener('DOMContentLoaded', () => {
    // View Selector Events
    document.getElementById('listViewBtn').addEventListener('click', () => switchView('list'));
    document.getElementById('calendarViewBtn').addEventListener('click', () => switchView('calendar'));

    // Open New Appointment Modal
    document.getElementById('showModalBtn').addEventListener('click', () => {
        document.getElementById('newAppointmentModal').style.display = 'block';
        document.getElementById('requesterNameWrapper').style.display = currentRole === 'requester' ? 'block' : 'none';
    });

    // Close Modals
    document.getElementById('cancelModalBtn').addEventListener('click', () => closeModal('newAppointmentModal'));
    document.getElementById('cancelRescheduleBtn').addEventListener('click', () => closeModal('rescheduleModal'));
    document.getElementById('closeDetailModalBtn').addEventListener('click', () => closeModal('appointmentDetailModal'));

    document.getElementById("roleCounselor").addEventListener("click", () => switchRole("counselor"));
    document.getElementById("roleRequester").addEventListener("click", () => switchRole("requester"));

    renderAppointments();
    renderCalendar();
});

// Function to switch roles
function switchRole(role) {
    currentRole = role;
    toggleRequesterNameField();
    // Additional logic if needed, such as updating UI elements
}

// Toggle visibility of the requester name input
function toggleRequesterNameField() {
    if (currentRole === 'requester') {
        document.getElementById('requesterNameWrapper').style.display = 'block';
    } else {
        document.getElementById('requesterNameWrapper').style.display = 'none';
    }
}


function switchView(view) {
    document.getElementById('listView').style.display = view === 'list' ? 'block' : 'none';
    document.getElementById('calendarView').style.display = view === 'calendar' ? 'block' : 'none';

    document.getElementById('listViewBtn').classList.toggle('active', view === 'list');
    document.getElementById('calendarViewBtn').classList.toggle('active', view === 'calendar');
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Function to render appointments in the list view
function renderAppointments() {
    const tbody = document.getElementById('appointmentsBody');
    tbody.innerHTML = '';
    appointments.forEach(appointment => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${appointment.studentName}</td>
            <td>${appointment.date} ${appointment.time}</td>
            <td>${appointment.requester}</td>
            <td>${appointment.reason}</td>
            <td>${appointment.status}</td>
            <td>
                <button onclick="viewDetails(${appointment.id})">View</button>
                <button onclick="openRescheduleModal(${appointment.id})">Reschedule</button>
                <button onclick="cancelAppointment(${appointment.id})" class="btn-cancel">Cancel</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to view appointment details
function viewDetails(appointmentId) {
    const appointment = appointments.find(a => a.id === appointmentId);
    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    document.getElementById('appointmentDetailContent').innerHTML = `
        <p><strong>Student:</strong> ${appointment.studentName}</p>
        <p><strong>Date & Time:</strong> ${appointment.date} ${appointment.time}</p>
        <p><strong>Requester:</strong> ${appointment.requester}</p>
        <p><strong>Reason:</strong> ${appointment.reason}</p>
        <p><strong>Status:</strong> ${appointment.status}</p>
    `;

    document.getElementById('appointmentDetailModal').style.display = 'block';
}

// Function to cancel an appointment
function cancelAppointment(appointmentId) {
    const appointment = appointments.find(a => a.id === appointmentId);
    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    if (!confirm("Are you sure you want to cancel this appointment?")) {
        return;
    }

    appointment.status = "canceled";
    renderAppointments();
    renderCalendar();
}
function approveAppointment(appointmentId) {
    const appointment = appointments.find(a => a.id === appointmentId);
    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    appointment.status = "approved";
    notifyUsers(appointment, "approved");
    renderAppointments();
    renderCalendar();
}

// Function to decline an appointment
function declineAppointment(appointmentId) {
    const appointment = appointments.find(a => a.id === appointmentId);
    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    if (!confirm("Are you sure you want to decline this appointment?")) {
        return;
    }

    appointment.status = "declined";
    notifyUsers(appointment, "declined");
    renderAppointments();
    renderCalendar();
}

// Function to notify users when appointment is updated
function notifyUsers(appointment, action) {
    const message = `Your appointment for ${appointment.studentName} on ${appointment.date} at ${appointment.time} has been ${action}.`;
    alert(message); // Simulating a notification system
}

// Update the renderAppointments function to include Approve & Decline buttons for counselors
function renderAppointments() {
    const tbody = document.getElementById('appointmentsBody');
    tbody.innerHTML = '';

    appointments.forEach(appointment => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${appointment.studentName}</td>
            <td>${appointment.date} ${appointment.time}</td>
            <td>${appointment.requester}</td>
            <td>${appointment.reason}</td>
            <td>${appointment.status}</td>
            <td>
                <button onclick="viewDetails(${appointment.id})">View</button>
                <button onclick="openRescheduleModal(${appointment.id})">Reschedule</button>
                <button onclick="cancelAppointment(${appointment.id})" class="btn-cancel">Cancel</button>
                ${currentRole === 'counselor' && appointment.status === 'pending' ? `
                    <button onclick="approveAppointment(${appointment.id})" class="btn-approve">Approve</button>
                    <button onclick="declineAppointment(${appointment.id})" class="btn-decline">Decline</button>
                ` : ''}
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to open Reschedule Modal
function openRescheduleModal(appointmentId) {
    const appointment = appointments.find(a => a.id === appointmentId);
    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    document.getElementById('rescheduleDate').value = appointment.date;
    document.getElementById('rescheduleTime').value = appointment.time;
    document.getElementById('rescheduleReason').value = '';

    document.getElementById('rescheduleForm').dataset.appointmentId = appointmentId;
    document.getElementById('rescheduleModal').style.display = 'block';
}

// Event listener for rescheduling
document.getElementById('rescheduleForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const appointmentId = document.getElementById('rescheduleForm').dataset.appointmentId;
    const appointment = appointments.find(a => a.id == appointmentId);

    if (!appointment) {
        alert('Appointment not found.');
        return;
    }

    appointment.date = document.getElementById('rescheduleDate').value;
    appointment.time = document.getElementById('rescheduleTime').value;
    appointment.status = 'rescheduled';

    renderAppointments();
    renderCalendar();

    document.getElementById('rescheduleModal').style.display = 'none';
});

// Close Reschedule Modal
document.getElementById('cancelRescheduleBtn').addEventListener('click', () => {
    document.getElementById('rescheduleModal').style.display = 'none';
});

// CALENDAR VIEW FUNCTIONALITY
let currentDate = new Date();
function renderCalendar() {
    const calendarGrid = document.getElementById('calendarGrid');
    const monthName = document.getElementById('monthName');
    calendarGrid.innerHTML = '';

    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    const firstDayIndex = firstDay.getDay();

    for (let i = 0; i < firstDayIndex; i++) {
        const emptyCell = document.createElement('div');
        calendarGrid.appendChild(emptyCell);
    }

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day).toISOString().split('T')[0];
        const cell = document.createElement('div');
        cell.classList.add('calendar-cell');
        cell.textContent = day;
        cell.onclick = () => showAppointmentsForDay(date);

        if (appointments.some(a => a.date === date)) {
            cell.classList.add('has-appointments');
        }

        calendarGrid.appendChild(cell);
    }

    monthName.textContent = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
}

document.getElementById('prevBtn').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById('nextBtn').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

function showAppointmentsForDay(date) {
    alert(`Appointments for ${date}:\n` + appointments.filter(a => a.date === date).map(a => `${a.time} - ${a.studentName}`).join('\n'));
}
document.getElementById('newAppointmentForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const studentName = document.getElementById('studentName').value;
    const requesterName = document.getElementById('requesterName').value;
    const date = document.getElementById('appointmentDate').value;
    const time = document.getElementById('appointmentTime').value;
    const requesterType = document.getElementById('requesterType').value;
    const reason = document.getElementById('appointmentReason').value;

    const newAppointment = {
        id: appointments.length + 1,
        studentName,
        requesterName,
        date,
        time,
        requester: requesterType,
        reason,
        status: 'pending'
    };

    appointments.push(newAppointment);
    renderAppointments();
    document.getElementById('newAppointmentModal').style.display = 'none';
});