Dear {{ $application->listing->company}},
<p>
This is to inform you that the application from {{ $application->name }} for the position of **{{ $application->listing->title }}** has been withdrawn.
</p>
<p>
Here are the details of the withdrawn application: <br>
- Applicant Name: {{ $application->name }} <br>
- Position: {{ $application->listing->title }} <br>
- Application Date: {{ $application->created_at->format('F j, Y') }}
</p>
<p>
If you have any questions or need further assistance, please feel free to contact us.
</p>
<p>
Thank you for your understanding.
</p>
Best regards,<br>
Job Sphere
