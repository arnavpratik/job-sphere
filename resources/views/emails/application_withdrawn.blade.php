@if($application->listing && $application->user)
<p>Dear <strong>{{ $application->name }}</strong>,</p>
<p>
We wanted to let you know that your application for the position of <strong>{{ $application->listing->title }}</strong> in <strong>{{$application->listing->company}}</strong> has been successfully withdrawn.
</p>
<p>
If you have any questions or need further assistance, please feel free to contact us.
</p>
Best regards,<br>
Job Sphere
@else
    <p>Some details were missing for this application.</p>
@endif
<p>Thank you.</p>
