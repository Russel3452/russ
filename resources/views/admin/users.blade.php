@extends('layouts.app')

@section('title', 'Users - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-users"></i> User Management</h2>
        <p class="text-muted">Manage all system users</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New User
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="coordinator" {{ request('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                        <option value="participant" {{ request('role') == 'participant' ? 'selected' : '' }}>Participant</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-card-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $adminCount ?? 0 }}</div>
                <div class="stat-card-label">Admins</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $coordinatorCount ?? 0 }}</div>
                <div class="stat-card-label">Coordinators</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-user"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $participantCount ?? 0 }}</div>
                <div class="stat-card-label">Participants</div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list"></i> All Users</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; margin-right: 10px;">
                                        <strong>{{ strtoupper(substr($user->name, 0, 1)) }}</strong>
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user-shield"></i> Admin
                                    </span>
                                @elseif($user->role === 'coordinator')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-user-tie"></i> Coordinator
                                    </span>
                                @else
                                    <span class="badge badge-info">
                                        <i class="fas fa-user"></i> Participant
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(($user->status ?? 'active') === 'active')
                                    <span class="badge" style="background: #56ab2f; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @else
                                    <span class="badge" style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-times-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($users) && $users->hasPages())
            <div class="mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
