@extends('layouts.app')

@section('title', 'Programs - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-clipboard-list"></i> Program Management</h2>
        <p class="text-muted">Manage all wellness programs</p>
    </div>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Program
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.programs') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search programs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="fitness" {{ request('category') == 'fitness' ? 'selected' : '' }}>Fitness</option>
                        <option value="nutrition" {{ request('category') == 'nutrition' ? 'selected' : '' }}>Nutrition</option>
                        <option value="mental health" {{ request('category') == 'mental health' ? 'selected' : '' }}>Mental Health</option>
                        <option value="wellness" {{ request('category') == 'wellness' ? 'selected' : '' }}>Wellness</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $totalPrograms ?? 0 }}</div>
                <div class="stat-card-label">Total Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $activePrograms ?? 0 }}</div>
                <div class="stat-card-label">Active Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $totalParticipants ?? 0 }}</div>
                <div class="stat-card-label">Total Participants</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $totalCoordinators ?? 0 }}</div>
                <div class="stat-card-label">Coordinators</div>
            </div>
        </div>
    </div>
</div>

<!-- Programs Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list"></i> All Programs</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Program Name</th>
                        <th>Category</th>
                        <th>Coordinator</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td>{{ $program->id }}</td>
                            <td>
                                <div>
                                    <strong>{{ $program->name }}</strong>
                                    @if($program->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($program->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: #3498db; color: white; padding: 5px 10px; border-radius: 15px;">
                                    {{ ucfirst($program->category) }}
                                </span>
                            </td>
                            <td>
                                @if($program->coordinator)
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; font-size: 0.8rem; font-weight: bold; margin-right: 8px;">
                                            {{ strtoupper(substr($program->coordinator->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $program->coordinator->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background: #f2994a; color: white; padding: 5px 10px; border-radius: 15px;">
                                    <i class="fas fa-users"></i> {{ $program->registrations_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @if($program->status === 'active')
                                    <span class="badge" style="background: #56ab2f; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @elseif($program->status === 'completed')
                                    <span class="badge" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-flag-checkered"></i> Completed
                                    </span>
                                @else
                                    <span class="badge" style="background: #95a5a6; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-pause-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>{{ $program->start_date ? $program->start_date->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.programs.show', $program->id) }}" class="btn btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No programs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programs->hasPages())
            <div class="mt-4">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
