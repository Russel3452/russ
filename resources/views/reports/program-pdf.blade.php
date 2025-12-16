<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Program Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #56ab2f;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #56ab2f;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #56ab2f;
            color: white;
            padding: 10px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #56ab2f;
            font-size: 10px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
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
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-active {
            background-color: #56ab2f;
            color: white;
        }
        .badge-upcoming {
            background-color: #3498db;
            color: white;
        }
        .badge-completed {
            background-color: #95a5a6;
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
        <h1>Program Report</h1>
        <p><strong>Health & Wellness Tracker</strong></p>
        <p>Generated on: {{ $generatedDate }}</p>
        <p>Total Programs: {{ count($programs) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">ID</th>
                <th width="18%">Name</th>
                <th width="10%">Category</th>
                <th width="13%">Coordinator</th>
                <th width="8%">Status</th>
                <th width="7%">Participants</th>
                <th width="7%">Capacity</th>
                <th width="10%">Start Date</th>
                <th width="10%">End Date</th>
                <th width="13%">Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $program)
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ ucfirst($program->category) }}</td>
                    <td>{{ $program->coordinator ? $program->coordinator->name : 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $program->status }}">
                            {{ ucfirst($program->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">{{ $program->registrations_count }}</td>
                    <td style="text-align: center;">{{ $program->capacity ?? 'N/A' }}</td>
                    <td>{{ $program->start_date ?? 'N/A' }}</td>
                    <td>{{ $program->end_date ?? 'N/A' }}</td>
                    <td>{{ $program->location ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Health & Wellness Tracker - Confidential Document</p>
    </div>
</body>
</html>
