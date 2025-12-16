@extends('layouts.app')

@section('title', 'Progress Tracking')

@section('content')
<div class="mb-4">
    <a href="{{ route('participant.my-programs') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left"></i> Back to My Programs
    </a>
</div>

<div class="row g-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $registration->program->name }} - Progress</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="fw-bold">My Health Goals</h5>
                    <p>{{ $registration->health_goals ?? 'No goals set' }}</p>
                    
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateGoalsModal">
                        <i class="fas fa-edit"></i> Update Goals
                    </button>
                </div>

                <hr>

                <h5 class="fw-bold mb-3">Progress Metrics</h5>
                
                @forelse($registration->progressMetrics as $metric)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold">{{ $metric->metric_type }}</h6>
                                    <p class="mb-1">
                                        <span class="fs-4 fw-bold text-primary">{{ $metric->metric_value }}</span>
                                        @if($metric->unit)
                                            <span class="text-muted">{{ $metric->unit }}</span>
                                        @endif
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> {{ $metric->recorded_date->format('M d, Y') }}
                                        | Recorded by {{ $metric->recorder->name }}
                                    </small>
                                    @if($metric->notes)
                                        <p class="mt-2 mb-0"><em>{{ $metric->notes }}</em></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No progress metrics recorded yet. Your coordinator will add metrics as you progress through the program.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Update Goals Modal -->
<div class="modal fade" id="updateGoalsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('participant.progress.update-goals', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update Health Goals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="health_goals" class="form-label">Health Goals *</label>
                        <textarea class="form-control" id="health_goals" name="health_goals" rows="3" required>{{ $registration->health_goals }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="personal_notes" class="form-label">Personal Notes</label>
                        <textarea class="form-control" id="personal_notes" name="personal_notes" rows="2">{{ $registration->personal_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Goals</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
