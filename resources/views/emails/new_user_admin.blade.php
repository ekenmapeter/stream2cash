<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Alert</title>
</head>
<body>
    <h2>🚨 New User Registered</h2>
    <p>A new user has just signed up:</p>
    <ul>
        <li><strong>Name:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Registered at:</strong> {{ $user->created_at }}</li>
    </ul>
    <br>
    <p>Log in to your admin panel for more details.</p>
</body>
</html>
