<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Report Submitted</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            margin: 30px auto;
            padding: 30px;
            max-width: 650px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            border-top: 6px solid #d9534f;
        }

        h2 {
            color: #d9534f;
            margin-bottom: 10px;
        }

        p.intro {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .reason-badge {
            display: inline-block;
            padding: 5px 12px;
            background-color: #f0ad4e;
            color: #fff;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🚨 New Report Submitted</h2>
        <p class="intro">A new report has been submitted on the platform. Details are as follows:</p>

        <table>
            <tr>
                <th colspan="2">Reporter Details</th>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $reportData['reporter_name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $reportData['reporter_email'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>ID</th>
                <td>{{ $reportData['reporter_id'] ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th colspan="2">Reported User / Post Owner Details</th>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $reportData['reported_user_name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $reportData['reported_user_email'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>ID</th>
                <td>{{ $reportData['reported_user_id'] ?? 'N/A' }}</td>
            </tr>

            @if (isset($reportData['post_id']))
                <tr>
                    <th>Post ID</th>
                    <td>{{ $reportData['post_id'] }}</td>
                </tr>
            @endif

            <tr>
                <th>Reason</th>
                <td><span class="reason-badge">{{ $reportData['reason'] }}</span></td>
            </tr>
        </table>

        <div class="footer">
            This is an automated message. Please review the report in the admin panel.
        </div>
    </div>
</body>

</html>
