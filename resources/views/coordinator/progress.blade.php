@extends('layouts.app')

@section('title', 'Participant Progress - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coordinator.participants', $registration->program_id) }}">{{ $registration->program->name }}</a></li>
            <li class="breadcrumb-item active">{{ $registration->user->name }}</li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-chart-line"></i> Participant Progress</h2>
    <p class="text-muted">{{ $registration->user->name }} - {{ $registration->program->name }}</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Progress Metrics</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMetricModal">
                    <i class="fas fa-plus"></i> Add Metric
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Metric Type</th>
                                <th>Value</th>
                                <th>Recorded Date</th>
                                <th>Recorded By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registration->progressMetrics as $metric)
                                <tr>
                                    <td><strong>{{ $metric->metric_type }}</strong></td>
                                    <td>{{ $metric->metric_value }} {{ $metric->unit }}</td>
                                    <td>{{ $metric->recorded_date->format('M d, Y') }}</td>
                                    <td>{{ $metric->recorder->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" 
                                                    class="btn btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editMetricModal{{ $metric->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editMetricModal{{ $metric->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Progress Metric</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('coordinator.progress.update', [$registration->id, $metric->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Metric Type</label>
                                                                <input type="text" class="form-control" name="metric_type" value="{{ $metric->metric_type }}" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Value</label>
                                                                        <input type="text" class="form-control" name="metric_value" value="{{ $metric->metric_value }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Unit</label>
                                                                        <input type="text" class="form-control" name="unit" value="{{ $metric->unit }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Recorded Date</label>
                                                                <input type="date" class="form-control" name="recorded_date" value="{{ $metric->recorded_date->format('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Notes</label>
                                                                <textarea class="form-control" name="notes" rows="3">{{ $metric->notes }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update Metric</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if($metric->notes)
                                    <tr>
                                        <td colspan="5" class="bg-light">
                                            <small><strong>Notes:</strong> {{ $metric->notes }}</small>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-muted mb-0">No progress metrics recorded yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                <h5 class="mb-3"><i class="fas fa-user"></i> Participant Info</h5>
                <div class="mb-2">
                    <strong>Name:</strong> {{ $registration->user->name }}
                </div>
                <div class="mb-2">
                    <strong>Email:</strong> {{ $registration->user->email }}
                </div>
                @if($registration->user->phone)
                    <div class="mb-2">
                        <strong>Phone:</strong> {{ $registration->user->phone }}
                    </div>
                @endif
                <div class="mb-2">
                    <strong>Registered:</strong> {{ $registration->registered_at->format('M d, Y') }}
                </div>
                <div>
                    <strong>Status:</strong>
                    @if($registration->status === 'registered' || $registration->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($registration->status === 'completed')
                        <span class="badge bg-info">Completed</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($registration->status) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-lightbulb"></i> Progress Tracking Tips</h6>
                <ul class="small text-muted mb-0">
                    <li class="mb-2">Record metrics regularly for better tracking</li>
                    <li class="mb-2">Use consistent units for comparable data</li>
                    <li class="mb-2">Add notes for context and observations</li>
                    <li class="mb-2">Review trends to adjust program approach</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add Metric Modal -->
<div class="modal fade" id="addMetricModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Progress Metric</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('coordinator.progress.store', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Metric Type <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="metric_type" placeholder="e.g., Weight, Blood Pressure, Steps" required>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Value <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="metric_value" placeholder="e.g., 150" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="unit" placeholder="lbs, kg, etc.">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recorded Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="recorded_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Additional observations or context"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Metric</button>
                </div>
            </form>
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
