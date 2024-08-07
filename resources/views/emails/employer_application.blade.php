<!DOCTYPE html>
<html>
<head>
    <title>New Job Application Received</title>
</head>
<body>
    <h1>New Job Application Received</h1>
    <p>You have received a new job application for the position: {{ $listing->title }}.</p>
    <p>Candidate Details:</p>
    <ul>
        <li>Name: {{ $candidate->name }}</li>
        <li>Email: {{ $candidate->email }}</li>
        <li>Mobile: {{ $candidate->mobile }}</li>
    </ul>
    <p>The candidate's resume is attached to this email.</p>
</body>
</html>
