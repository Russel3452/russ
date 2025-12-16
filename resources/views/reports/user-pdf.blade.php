<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e3c72;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #1e3c72;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            background-color: #1e3c72;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e3c72;
        }
        td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-admin {
            background-color: #dc3545;
            color: white;
        }
        .badge-coordinator {
            background-color: #f2994a;
            color: white;
        }
        .badge-participant {
            background-color: #3498db;
            color: white;
        }
        .badge-active {
            background-color: #56ab2f;
            color: white;
        }
        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Report</h1>
        <p><strong>Health & Wellness Tracker</strong></p>
        <p>Generated on: {{ $generatedDate }}</p>
        <p>Total Users: {{ count($users) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="20%">Name</th>
                <th width="25%">Email</th>
                <th width="12%">Role</th>
                <th width="15%">Phone</th>
                <th width="10%">Status</th>
                <th width="13%">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $user->status ?? 'active' }}">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Health & Wellness Tracker - Confidential Document</p>
    </div>
</body>
</html>
