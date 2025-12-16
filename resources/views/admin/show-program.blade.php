@extends('layouts.app')

@section('title', 'Program Details - Admin')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.programs') }}">Programs</a></li>
            <li class="breadcrumb-item active">{{ $program->name }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold" style="color: #1e3c72;">
                <i class="fas fa-clipboard-list"></i> {{ $program->name }}
            </h2>
            <p class="text-muted">Program Details and Information</p>
        </div>
        <div>
            @if($program->status === 'active')
                <span class="badge" style="background: #56ab2f; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-check-circle"></i> Active
                </span>
            @elseif($program->status === 'completed')
                <span class="badge" style="background: #3498db; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-flag-checkered"></i> Completed
                </span>
            @else
                <span class="badge" style="background: #95a5a6; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-pause-circle"></i> Inactive
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $program->registrations_count }}</div>
                <div class="stat-card-label">Total Participants</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $program->sessions->count() }}</div>
                <div class="stat-card-label">Total Sessions</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $program->registrations->where('status', 'active')->count() }}</div>
                <div class="stat-card-label">Active Participants</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $program->registrations->where('status', 'completed')->count() }}</div>
                <div class="stat-card-label">Completed</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Program Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Program Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Category</label>
                        <p class="mb-0">
                            <span class="badge" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 15px;">
                                {{ ucfirst($program->category) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Duration</label>
                        <p class="mb-0"><strong>{{ $program->duration ?? 'N/A' }}</strong></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Start Date</label>
                        <p class="mb-0"><strong>{{ $program->start_date ? $program->start_date->format('F d, Y') : 'N/A' }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">End Date</label>
                        <p class="mb-0"><strong>{{ $program->end_date ? $program->end_date->format('F d, Y') : 'N/A' }}</strong></p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Description</label>
                    <p class="mb-0">{{ $program->description ?? 'No description available.' }}</p>
                </div>

                @if($program->location)
                    <div class="mb-3">
                        <label class="text-muted small">Location</label>
                        <p class="mb-0"><i class="fas fa-map-marker-alt text-primary"></i> {{ $program->location }}</p>
                    </div>
                @endif

                @if($program->max_participants)
                    <div class="mb-3">
                        <label class="text-muted small">Capacity</label>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ ($program->registrations_count / $program->max_participants) * 100 }}%; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);"
                                 aria-valuenow="{{ $program->registrations_count }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $program->max_participants }}">
                                {{ $program->registrations_count }} / {{ $program->max_participants }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Participants List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users"></i> Participants</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($program->registrations as $registration)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; font-weight: bold; margin-right: 10px;">
                                                {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $registration->user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $registration->user->email }}</td>
                                    <td>
                                        @if($registration->status === 'active')
                                            <span class="badge" style="background: #56ab2f; color: white; padding: 5px 10px; border-radius: 15px;">
                                                Active
                                            </span>
                                        @elseif($registration->status === 'completed')
                                            <span class="badge" style="background: #3498db; color: white; padding: 5px 10px; border-radius: 15px;">
                                                Completed
                                            </span>
                                        @else
                                            <span class="badge" style="background: #95a5a6; color: white; padding: 5px 10px; border-radius: 15px;">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-muted mb-0">No participants registered yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Coordinator Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-tie"></i> Coordinator</h5>
            </div>
            <div class="card-body">
                @if($program->coordinator)
                    <div class="text-center mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; font-size: 2rem; font-weight: bold;">
                            {{ strtoupper(substr($program->coordinator->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="text-center">
                        <h6 class="fw-bold mb-1">{{ $program->coordinator->name }}</h6>
                        <p class="text-muted small mb-2">{{ $program->coordinator->email }}</p>
                        @if($program->coordinator->phone)
                            <p class="text-muted small mb-0">
                                <i class="fas fa-phone"></i> {{ $program->coordinator->phone }}
                            </p>
                        @endif
                    </div>
                @else
                    <p class="text-muted text-center">No coordinator assigned</p>
                @endif
            </div>
        </div>

        <!-- Sessions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Sessions</h5>
            </div>
            <div class="card-body">
                @forelse($program->sessions->take(5) as $session)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="fw-bold mb-1">{{ $session->topic }}</h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-calendar"></i> {{ $session->session_date ? $session->session_date->format('M d, Y') : 'TBD' }}
                        </p>
                        @if($session->location)
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt"></i> {{ $session->location }}
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted text-center">No sessions scheduled</p>
                @endforelse

                @if($program->sessions->count() > 5)
                    <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-2">
                        View All Sessions ({{ $program->sessions->count() }})
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.programs') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Programs
    </a>
</div>
@endsection
