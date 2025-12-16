@extends('layouts.app')

@section('title', 'Program Sessions - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item active">{{ $program->name }}</li>
        </ol>
    </nav>
</div>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-calendar"></i> Program Sessions</h2>
        <p class="text-muted">{{ $program->name }}</p>
    </div>
    <a href="{{ route('coordinator.sessions.create', $program->id) }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Session
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $sessions->count() }}</div>
                <div class="stat-card-label">Total Sessions</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $sessions->where('session_date', '<', now())->count() }}</div>
                <div class="stat-card-label">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $sessions->where('session_date', '>=', now())->count() }}</div>
                <div class="stat-card-label">Upcoming</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $program->registrations_count ?? 0 }}</div>
                <div class="stat-card-label">Participants</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list"></i> All Sessions</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
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
                                <strong>{{ $session->topic }}</strong>
                                @if($session->description)
                                    <br><small class="text-muted">{{ Str::limit($session->description, 60) }}</small>
                                @endif
                            </td>
                            <td>{{ $session->session_date->format('M d, Y h:i A') }}</td>
                            <td>{{ $session->location ?? 'TBD' }}</td>
                            <td>{{ $session->duration_minutes ?? 'N/A' }}</td>
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
                                    <a href="{{ route('coordinator.sessions.edit', [$program->id, $session->id]) }}" 
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
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted mb-3">No Sessions Yet</h5>
                                <p class="text-muted mb-4">Start by adding the first session for this program</p>
                                <a href="{{ route('coordinator.sessions.create', $program->id) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add First Session
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #64748b;
    }
    
    .breadcrumb-item a {
        color: #1e3c72;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #64748b;
    }
</style>
@endsection
