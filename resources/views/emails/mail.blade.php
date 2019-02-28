@php
$status_name = '';
if ($old_status == 1 || $data['status'] == 1) { $status_name = 'Received';}
if ($old_status == 2 || $data['status'] == 2) { $status_name = 'Assigned';}
if ($old_status == 3 || $data['status'] == 3) { $status_name = 'On Hold';}
if ($old_status == 4 || $data['status'] == 4) { $status_name = 'Completed';}
if ($old_status == 5 || $data['status'] == 5) { $status_name = 'Submitted for Vetting';}
if ($old_status == 6 || $data['status'] == 6) { $status_name = 'Invoiced';}
if ($old_status == 7 || $data['status'] == 7) { $status_name = 'Paid';}
if ($old_status == 8 || $data['status'] == 8) { $status_name = 'Cancelled';}
@endphp

Jobcard Status changed from {{ $status_name }} to {{ $status_name }}

Thank you