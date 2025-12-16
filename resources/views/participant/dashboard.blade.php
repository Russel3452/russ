@extends('layouts.app')

@section('title', 'Dashboard - Participant')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-tachometer-alt"></i> My Dashboard</h2>
    <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $registrations->count() }}</div>
                <div class="stat-card-label">Active Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $upcomingSessions->count() }}</div>
                <div class="stat-card-label">Upcoming Sessions</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ auth()->user()->attendance()->count() }}</div>
                <div class="stat-card-label">Total Attendance</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $registrations->where('status', 'completed')->count() }}</div>
                <div class="stat-card-label">Completed Programs</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calendar-alt"></i> Upcoming Sessions
            </div>
            <div class="card-body">
                @forelse($upcomingSessions as $session)
                    <div class="session-card {{ $session->isToday() ? 'today' : '' }} card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $session->topic }}</h5>
                                    <p class="text-muted mb-2">{{ $session->program->name }}</p>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar"></i> {{ $session->session_date->format('M d, Y') }}
                                        <i class="fas fa-clock ms-3"></i> {{ $session->session_date->format('h:i A') }}
                                        @if($session->location)
                                            <i class="fas fa-map-marker-alt ms-3"></i> {{ $session->location }}
                                        @endif
                                    </p>
                                </div>
                                @if($session->isToday())
                                    <form action="{{ route('participant.check-in', $session->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Check In
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">No upcoming sessions</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bookmark"></i> My Programs
            </div>
            <div class="card-body">
                @forelse($registrations as $registration)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="fw-bold mb-1">{{ $registration->program->name }}</h6>
                        <p class="text-muted small mb-2">{{ $registration->program->category }}</p>
                        <span class="badge badge-{{ $registration->status === 'active' ? 'success' : 'info' }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center">No active programs</p>
                @endforelse
                <a href="{{ route('participant.programs') }}" class="btn btn-primary w-100 mt-2">
                    <i class="fas fa-search"></i> Browse Programs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
