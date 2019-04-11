@php
$new_status_name = '';
$old_status_name = '';

if ($old_status == 1) { $old_status_name = 'Received';}
if ($data['status'] == 1) { $new_status_name = 'Received';}

if ($old_status == 2) { $old_status_name = 'Assigned';}
if ($data['status'] == 2) { $new_status_name = 'Assigned';}

if ($old_status == 3) { $old_status_name = 'On Hold';}
if ($data['status'] == 3) { $new_status_name = 'On Hold';}

if ($old_status == 4) { $old_status_name = 'Completed';}
if ($data['status'] == 4) { $new_status_name = 'Completed';}

if ($old_status == 5) { $old_status_name = 'Submitted for Vetting';}
if ($data['status'] == 5) { $new_status_name = 'Submitted for Vetting';}

if ($old_status == 6) { $old_status_name = 'Invoiced';}
if ($data['status'] == 6) { $new_status_name = 'Invoiced';}

if ($old_status == 7) { $old_status_name = 'Paid';}
if ($data['status'] == 7) { $new_status_name = 'Paid';}

if ($old_status == 8) { $old_status_name = 'Cancelled';}
if ($data['status'] == 8) { $new_status_name = 'Cancelled';}

@endphp

Jobcard Status changed from {{ $old_status }} to {{ $data['status'] }}


Thank you