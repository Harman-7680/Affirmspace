<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Counselor Documents</title>
</head>

<body style="font-family: Arial; background:#f5f5f5; padding:20px;">

    <div style="max-width:600px; background:white; padding:20px; border-radius:6px; margin:auto;">

        <h2 style="color:#333;">New Counselor Document Submission</h2>

        <p>A counselor has uploaded documents for verification.</p>

        <hr>

        <p><strong>Name:</strong> {{ $user->name }}</p>

        <p><strong>Email:</strong> {{ $user->email }}</p>

        <p><strong>User ID:</strong> {{ $user->id }}</p>

        <hr>

        <br>

        <p>Please login to admin panel to verify documents.</p>

    </div>

</body>

</html>
