<?php

function formatNotification($type, $data = []) {
    switch ($type) {
        case 'student_added':
            return "A new student record for {$data['lname']}, {$data['fname']} (ID: {$data['id_num']}) has been added to the system.";
        case 'case_filed':
            return "A new case of type '{$data['case_type']}' has been filed for student {$data['lname']}, {$data['fname']} (ID: {$data['id_num']}).";
        case 'appointment_booked':
            return "An appointment has been scheduled for {$data['lname']}, {$data['fname']} on {$data['date']} at {$data['time']}.";
        case 'account_status_changed':
            return "The account for {$data['lname']}, {$data['fname']} (ID: {$data['id_num']}) has been set to {$data['status']}.";
        case 'case_updated':
            return "Case #{$data['case_id']} for student {$data['lname']}, {$data['fname']} has been updated.";
        case 'case_archived':
            return "Case #{$data['case_id']} for student {$data['lname']}, {$data['fname']} has been archived.";
        case 'appointment_cancelled':
            return "The appointment for {$data['lname']}, {$data['fname']} on {$data['date']} has been cancelled.";
        case 'parent_account_pending':
            return "A parent account for {$data['guardian_name']} is pending approval.";
        case 'parent_account_approved':
            return "The parent account for {$data['guardian_name']} has been approved.";
        case 'parent_message_received':
            return "A new message has been received from parent {$data['guardian_name']} regarding student {$data['student_name']}.";
        case 'general':
            return $data['message'];
        default:
            return "A new notification has been received.";
    }
}
?>