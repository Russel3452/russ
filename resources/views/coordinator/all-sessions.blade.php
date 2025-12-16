@extends('layouts.app')

@section('title', 'All Sessions - Coordinator')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-calendar-alt"></i> All Sessions</h2>
    <p class="text-muted">Overview of all sessions across your programs</p>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Session Topic</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr>
                            <td>
                                <a href="{{ route('coordinator.sessions', $session->program_id) }}" class="text-decoration-none">
                                    {{ $session->program->name }}
                                </a>
                            </td>
                            <td>
                                <strong>{{ $session->topic }}</strong>
                                @if($session->description)
                                    <br><small class="text-muted">{{ Str::limit($session->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $session->session_date->format('M d, Y h:i A') }}</td>
                            <td>{{ $session->location ?? 'TBD' }}</td>
                            <td>{{ $session->duration_minutes ?? 'N/A' }} min</td>
                            <td>
                                @if($session->session_date < now())
                                    <span class="badge bg-secondary">Completed</span>
                                @elseif($session->session_date->isToday())
                                    <span class="badge bg-success">Today</span>
                                @else
                                    <span class="badge bg-warning">Upcoming</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('coordinator.sessions.edit', [$session->program_id, $session->id]) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('coordinator.attendance', $session->id) }}" 
                                       class="btn btn-outline-success" title="Attendance">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted mb-3">No Sessions Yet</h5>
                                <p class="text-muted mb-4">Create a program first, then add sessions to it</p>
                                <a href="{{ route('coordinator.programs.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Program
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $sessions->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
