<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #f2994a;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #f2994a;
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
            background-color: #f2994a;
            color: white;
            padding: 10px 7px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #f2994a;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px 7px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 12px;
        }
        .badge {
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-create {
            background-color: #56ab2f;
            color: white;
        }
        .badge-update {
            background-color: #f2994a;
            color: white;
        }
        .badge-delete {
            background-color: #dc3545;
            color: white;
        }
        .badge-generate_report {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Activity Report</h1>
        <p><strong>Health & Wellness Tracker - Audit Log</strong></p>
        <p>Generated on: {{ $generatedDate }}</p>
        <p>Total Activities: {{ count($activities) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="18%">User</th>
                <th width="12%">Action</th>
                <th width="15%">Model</th>
                <th width="8%">Model ID</th>
                <th width="20%">IP Address</th>
                <th width="22%">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td>{{ $activity->user ? $activity->user->name : 'System' }}</td>
                    <td>
                        <span class="badge badge-{{ $activity->action }}">
                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                        </span>
                    </td>
                    <td>{{ $activity->model }}</td>
                    <td>{{ $activity->model_id ?? 'N/A' }}</td>
                    <td>{{ $activity->ip_address ?? 'N/A' }}</td>
                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Health & Wellness Tracker - Confidential Audit Document</p>
    </div>
</body>
</html>
