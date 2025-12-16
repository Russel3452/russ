@extends('layouts.app')

@section('title', 'My Programs - Coordinator')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-clipboard-list"></i> My Programs</h2>
        <p class="text-muted">Manage your health and wellness programs</p>
    </div>
    <a href="{{ route('coordinator.programs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New Program
    </a>
</div>

<div class="row g-4">
    @forelse($programs as $program)
        <div class="col-lg-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0" style="color: #1e3c72;">{{ $program->name }}</h5>
                        @if($program->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif($program->status === 'completed')
                            <span class="badge bg-secondary">Completed</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </div>
                    
                    <p class="card-text text-muted mb-3">{{ Str::limit($program->description, 100) }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $program->start_date->format('M d, Y') }} - 
                            {{ $program->end_date->format('M d, Y') }}
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt"></i> {{ $program->location ?? 'Location TBD' }}
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <i class="fas fa-users text-primary"></i>
                            <span class="ms-1">{{ $program->registrations_count }} participants</span>
                        </div>
                        <div>
                            <i class="fas fa-calendar-check text-success"></i>
                            <span class="ms-1">{{ $program->sessions_count ?? 0 }} sessions</span>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('coordinator.programs.edit', $program->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('coordinator.sessions', $program->id) }}" class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-calendar"></i> Sessions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">No Programs Yet</h5>
                    <p class="text-muted mb-4">Start by creating your first health and wellness program</p>
                    <a href="{{ route('coordinator.programs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Your First Program
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<style>
    .card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }
    
    .card-title {
        font-weight: 600;
    }
</style>
@endsection
