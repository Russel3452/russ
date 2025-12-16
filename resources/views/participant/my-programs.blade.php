@extends('layouts.app')

@section('title', 'My Programs')

@section('content')
<div class="mb-4 fade-in">
    <h2 class="fw-bold"><i class="fas fa-bookmark"></i> My Programs</h2>
    <p class="text-muted">View and manage your registered programs</p>
</div>

<div class="row g-4">
    @forelse($registrations as $registration)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $registration->program->name }}</h5>
                    <span class="badge badge-{{ $registration->status === 'active' ? 'success' : 'info' }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ Str::limit($registration->program->description, 150) }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-tag"></i> {{ $registration->program->category }}<br>
                            <i class="fas fa-user"></i> {{ $registration->program->coordinator->name }}<br>
                            <i class="fas fa-calendar"></i> {{ $registration->program->start_date->format('M d') }} - {{ $registration->program->end_date->format('M d, Y') }}<br>
                            <i class="fas fa-clock"></i> Registered: {{ $registration->registered_at->format('M d, Y') }}
                        </small>
                    </div>

                    @if($registration->health_goals)
                        <div class="mb-3">
                            <strong>My Goals:</strong>
                            <p class="mb-0">{{ $registration->health_goals }}</p>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('participant.progress', $registration->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-chart-line"></i> View Progress
                        </a>
                        <a href="{{ route('participant.programs.show', $registration->program_id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> View Program
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No Programs Yet</h5>
                    <p class="text-muted">You haven't registered for any programs</p>
                    <a href="{{ route('participant.programs') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Browse Programs
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
