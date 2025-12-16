@extends('layouts.app')

@section('title', 'Program Participants - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item active">{{ $program->name }}</li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-users"></i> Program Participants</h2>
    <p class="text-muted">{{ $program->name }}</p>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Registered Participants</h5>
        <span class="badge bg-primary">{{ $registrations->count() }} / {{ $program->capacity }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <i class="fas fa-user-circle fa-2x text-muted"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $registration->user->name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $registration->user->email }}</td>
                            <td>{{ $registration->user->phone ?? 'N/A' }}</td>
                            <td>{{ $registration->registered_at->format('M d, Y') }}</td>
                            <td>
                                @if($registration->status === 'registered' || $registration->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($registration->status === 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @elseif($registration->status === 'withdrawn')
                                    <span class="badge bg-danger">Withdrawn</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($registration->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('coordinator.progress', $registration->id) }}" 
                                       class="btn btn-outline-primary" title="View Progress">
                                        <i class="fas fa-chart-line"></i>
                                    </a>
                                    @if($registration->status !== 'withdrawn')
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#removeModal{{ $registration->id }}"
                                                title="Remove Participant">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- Remove Modal -->
                                <div class="modal fade" id="removeModal{{ $registration->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Remove Participant</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('coordinator.participants.remove', [$program->id, $registration->id]) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to remove <strong>{{ $registration->user->name }}</strong> from this program?</p>
                                                    <div class="mb-3">
                                                        <label for="withdrawal_reason{{ $registration->id }}" class="form-label">Reason for Removal</label>
                                                        <textarea class="form-control" 
                                                                  id="withdrawal_reason{{ $registration->id }}" 
                                                                  name="withdrawal_reason" 
                                                                  rows="3" 
                                                                  required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Remove Participant</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted mb-3">No Participants Yet</h5>
                                <p class="text-muted mb-0">Participants will appear here once they register for this program</p>
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
