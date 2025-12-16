@extends('layouts.app')

@section('title', 'Audit Logs - Admin')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-history"></i> Audit Logs</h2>
    <p class="text-muted">Track all system activities and changes</p>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.audit-logs') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="model" class="form-select">
                        <option value="">All Models</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Program" {{ request('model') == 'Program' ? 'selected' : '' }}>Program</option>
                        <option value="Registration" {{ request('model') == 'Registration' ? 'selected' : '' }}>Registration</option>
                        <option value="Session" {{ request('model') == 'Session' ? 'selected' : '' }}>Session</option>
                        <option value="SystemSetting" {{ request('model') == 'SystemSetting' ? 'selected' : '' }}>System Setting</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Filter by date">
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
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $totalLogs ?? 0 }}</div>
                <div class="stat-card-label">Total Activities</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $createCount ?? 0 }}</div>
                <div class="stat-card-label">Creates</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-edit"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $updateCount ?? 0 }}</div>
                <div class="stat-card-label">Updates</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-trash"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $deleteCount ?? 0 }}</div>
                <div class="stat-card-label">Deletes</div>
            </div>
        </div>
    </div>
</div>

<!-- Audit Logs Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list"></i> Activity Log</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>IP Address</th>
                        <th>Date & Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs ?? [] as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>
                                @if($log->user)
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; font-size: 0.75rem; font-weight: bold; margin-right: 8px;">
                                            {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $log->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                            <td>
                                @if($log->action === 'create')
                                    <span class="badge" style="background: #56ab2f; color: white; padding: 5px 10px; border-radius: 15px;">
                                        <i class="fas fa-plus"></i> Create
                                    </span>
                                @elseif($log->action === 'update')
                                    <span class="badge" style="background: #f2994a; color: white; padding: 5px 10px; border-radius: 15px;">
                                        <i class="fas fa-edit"></i> Update
                                    </span>
                                @elseif($log->action === 'delete')
                                    <span class="badge" style="background: #dc3545; color: white; padding: 5px 10px; border-radius: 15px;">
                                        <i class="fas fa-trash"></i> Delete
                                    </span>
                                @else
                                    <span class="badge" style="background: #3498db; color: white; padding: 5px 10px; border-radius: 15px;">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                @endif
                            </td>
                            <td><strong>{{ $log->model }}</strong></td>
                            <td>#{{ $log->model_id }}</td>
                            <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                            <td>
                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                    <i class="fas fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for log details -->
                        <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                                        <h5 class="modal-title">Audit Log Details #{{ $log->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold">User:</label>
                                            <p>{{ $log->user->name ?? 'System' }} ({{ $log->user->email ?? 'N/A' }})</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Action:</label>
                                            <p>{{ ucfirst($log->action) }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Model:</label>
                                            <p>{{ $log->model }} (ID: {{ $log->model_id }})</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">IP Address:</label>
                                            <p>{{ $log->ip_address }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">User Agent:</label>
                                            <p class="text-muted small">{{ $log->user_agent ?? 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">Timestamp:</label>
                                            <p>{{ $log->created_at->format('F d, Y h:i:s A') }}</p>
                                        </div>
                                        @if($log->old_values && !empty($log->old_values))
                                            <div class="mb-3">
                                                <label class="fw-bold">Old Values:</label>
                                                <div class="bg-light p-3 rounded">
                                                    @foreach($log->old_values as $key => $value)
                                                        <div class="mb-2">
                                                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> 
                                                            <span>
                                                                @if(is_array($value))
                                                                    {{ implode(', ', array_map(fn($v) => is_scalar($v) ? $v : json_encode($v), $value)) }}
                                                                @elseif(is_object($value))
                                                                    {{ json_encode($value) }}
                                                                @else
                                                                    {{ $value ?? 'N/A' }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if($log->new_values && !empty($log->new_values))
                                            <div class="mb-3">
                                                <label class="fw-bold">New Values:</label>
                                                <div class="bg-light p-3 rounded">
                                                    @foreach($log->new_values as $key => $value)
                                                        <div class="mb-2">
                                                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> 
                                                            <span>
                                                                @if(is_array($value))
                                                                    {{ implode(', ', array_map(fn($v) => is_scalar($v) ? $v : json_encode($v), $value)) }}
                                                                @elseif(is_object($value))
                                                                    {{ json_encode($value) }}
                                                                @else
                                                                    {{ $value ?? 'N/A' }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No audit logs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($auditLogs) && $auditLogs->hasPages())
            <div class="mt-4">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
