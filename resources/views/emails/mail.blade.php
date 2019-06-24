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

<!-- RECEIVED -->
@php
if($data['status'] == 'Received') {
@endphp
Good day
<br><br>
This is an acknowledgement that we have received jobcards number <b>{{ $data['jobcard_num'] }}.</b> We will attend to this jobcard as soon as possible and will update you on every stage until closed.
@php
}
@endphp

<!-- Assigned -->
@php
if($data['status'] == 'Assigned') {
@endphp
 Good day
<br><br> 
This servers to notify you that jobcard number <b>{{ $data['jobcard_num'] }}.</b> which we received has been assigned to a technician today. We will let you know when it is completed in due course.
@php
}
@endphp

<!-- Completed -->
@php
if($data['status'] == 'Completed') {
@endphp
Good day
<br><br> 
This serves to notify you that the jobcard number <b>{{ $data['jobcard_num'] }}.</b> has been completed we will soon be submitting our quote for for your approval.
@php
}
@endphp

<!-- Cancelled -->
@php
if($data['status'] == 'Cancelled') {
@endphp
Good day
<br><br>
Please note that jobcard <b>{{ $data['jobcard_num'] }}.</b> has been cancelled please update your system to keep our performance metrics true.
@php
}
@endphp

<!-- Cancelled -->
@php
if($data['status'] != 'Received' && $data['status'] != 'Assigned' && $data['status'] != 'Completed' && $data['status'] != 'Cancelled') { 
@endphp
{{-- Jobcard Status changed from {{ $old_status }} to {{ $data['status'] }} --}}
Good day, This serves to notify you that the jobcard number <b>{{ $data['jobcard_num'] }}.</b> status has been changed to {{ $data['status'] }}
@php
}
@endphp

{{-- Jobcard Status changed from {{ $old_status }} to {{ $data['status'] }} --}}
<br><br>
Thank you
<br><br>
5ML Development 