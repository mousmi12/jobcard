<!DOCTYPE html>
<html>
<head>
    <title>{{ $reminder ? 'Project Reminder' : 'New Project Created' }}</title>
</head>
<body>
    <h1>{{ $reminder ? 'Project End Date Approaching' : 'A new project has been created' }}</h1>
    <p><strong>Project Name:</strong> {{ $project->name }}</p>
    <p><strong>Start Date:</strong> {{ $project->startdate }}</p>
    <p><strong>End Date:</strong> {{ $project->enddate }}</p>
    <p><strong>Description:</strong> {{ $project->description }}</p>
    <p><strong>Department:</strong> {{ $department->name }}</p>
    <p><strong>Priority:</strong> {{ $project->priority }}</p>
    <p><strong>User:</strong> {{ $user->name }}</p>
</body>
</html>
