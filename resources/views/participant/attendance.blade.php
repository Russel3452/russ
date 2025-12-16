@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')
<div class="mb-4 fade-in">
    <h2 class="fw-bold"><i class="fas fa-calendar-check"></i> My Attendance</h2>
    <p class="text-muted">View your session attendance history</p>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Session</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Check-in Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendance as $record)
                        <tr>
                            <td>{{ $record->session->program->name }}</td>
                            <td>{{ $record->session->topic }}</td>
                            <td>{{ $record->session->session_date->format('M d, Y h:i A') }}</td>
                            <td>
                                <span class="badge badge-{{ $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                            <td>
                                @if($record->checked_in_at)
                                    {{ $record->checked_in_at->format('h:i A') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No attendance records found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $attendance->links() }}
        </div>
    </div>
</div>
@endsection
