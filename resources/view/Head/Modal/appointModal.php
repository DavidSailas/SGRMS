<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment</title>
</head>
<body>
    <!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header modal-dark-header">
                <h5 class="modal-title" id="addAppointmentModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Schedule New Appointment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="appointment-form" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card modal-card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3">Student Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="studentName" class="form-label">Student Name *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control" id="studentName" placeholder="Enter student's full name" required>
                                                <div class="invalid-feedback">Please enter student name</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card modal-card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3">Requester Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="requesterName" class="form-label">Requester Name *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                <input type="text" class="form-control" id="requesterName" placeholder="Enter requester's full name" required>
                                                <div class="invalid-feedback">Please enter requester name</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="requesterType" class="form-label">Requester Type *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                <select class="form-select" id="requesterType" required>
                                                    <option value="">Select Type</option>
                                                    <option value="parent">Parent/Guardian</option>
                                                    <option value="teacher">Teacher</option>
                                                </select>
                                                <div class="invalid-feedback">Please select requester type</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card modal-card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-3">Appointment Details</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="appointmentDate" class="form-label">Appointment Date *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <input type="date" class="form-control" id="appointmentDate" required>
                                                <div class="invalid-feedback">Please select appointment date</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="appointmentTime" class="form-label">Appointment Time *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                <input type="time" class="form-control" id="appointmentTime" required>
                                                <div class="invalid-feedback">Please select appointment time</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="appointmentReason" class="form-label">Reason for Appointment *</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                <textarea class="form-control" id="appointmentReason" rows="3" placeholder="Please provide a brief description of the appointment purpose" required></textarea>
                                                <div class="invalid-feedback">Please enter appointment reason</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoApprove">
                                <label class="form-check-label" for="autoApprove">
                                    <i class="fas fa-check-circle text-success me-1"></i>Auto-approve this appointment
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-dark-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="save-appointment">
                    <i class="fas fa-save me-1"></i>Schedule Appointment
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>