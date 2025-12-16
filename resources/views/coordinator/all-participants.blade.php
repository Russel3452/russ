@extends('layouts.app')

@section('title', 'All Participants - Coordinator')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-users"></i> All Participants</h2>
    <p class="text-muted">Overview of all participants across your programs</p>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $registration)
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
                            <td>
                                <a href="{{ route('coordinator.participants', $registration->program_id) }}" class="text-decoration-none">
                                    {{ $registration->program->name }}
                                </a>
                            </td>
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
                                    <a href="{{ route('coordinator.participants', $registration->program_id) }}" 
                                       class="btn btn-outline-info" title="View Program">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted mb-3">No Participants Yet</h5>
                                <p class="text-muted mb-4">Participants will appear here once they register for your programs</p>
                                <a href="{{ route('coordinator.programs') }}" class="btn btn-primary">
                                    <i class="fas fa-clipboard-list"></i> View My Programs
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participants->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $participants->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
