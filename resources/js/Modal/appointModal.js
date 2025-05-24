    $(document).ready(function() {
        // Handle save appointment button click
        $('#save-appointment').on('click', function() {
            var formData = {
                studentName: $('#studentName').val().trim(),
                requesterName: $('#requesterName').val().trim(),
                requesterType: $('#requesterType').val(),
                appointmentDate: $('#appointmentDate').val(),
                appointmentTime: $('#appointmentTime').val(),
                reason: $('#appointmentReason').val().trim(),
                status: $('#autoApprove').is(':checked') ? 'approved' : 'pending'
            };

     
            $.ajax({
                url: '../../../app/Controllers/Head/AppointController/addappoint.php', 
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    if (response.success) {
                        // Close the modal
                        $('#addAppointmentModal').modal('hide');
                        // Clear the form
                        $('#appointment-form')[0].reset();
                        // Refresh the appointments table
                        loadAppointments(); // Ensure this function is defined to refresh the table
                        alert('Appointment added successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error adding appointment. Please try again.');
                }
            });
        });
    });

