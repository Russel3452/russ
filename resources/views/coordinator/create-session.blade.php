@extends('layouts.app')

@section('title', 'Create Session - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coordinator.sessions', $program->id) }}">{{ $program->name }}</a></li>
            <li class="breadcrumb-item active">Create Session</li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-plus-circle"></i> Create New Session</h2>
    <p class="text-muted">Add a new session to {{ $program->name }}</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('coordinator.sessions.store', $program->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="topic" class="form-label">Session Topic <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('topic') is-invalid @enderror" 
                               id="topic" 
                               name="topic" 
                               value="{{ old('topic') }}" 
                               required>
                        @error('topic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="facilitator" class="form-label">Facilitator</label>
                                <input type="text" 
                                       class="form-control @error('facilitator') is-invalid @enderror" 
                                       id="facilitator" 
                                       name="facilitator" 
                                       value="{{ old('facilitator') }}">
                                @error('facilitator')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="session_date" class="form-label">Session Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       class="form-control @error('session_date') is-invalid @enderror" 
                                       id="session_date" 
                                       name="session_date" 
                                       value="{{ old('session_date') }}" 
                                       required>
                                @error('session_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">Duration (minutes) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       id="duration_minutes" 
                                       name="duration_minutes" 
                                       value="{{ old('duration_minutes', 60) }}" 
                                       min="1" 
                                       required>
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Max Participants</label>
                        <input type="number" 
                               class="form-control @error('max_participants') is-invalid @enderror" 
                               id="max_participants" 
                               name="max_participants" 
                               value="{{ old('max_participants') }}" 
                               min="1">
                        <small class="text-muted">Leave empty for no limit</small>
                        @error('max_participants')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Session
                        </button>
                        <a href="{{ route('coordinator.sessions', $program->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle"></i> Program Information</h5>
                <hr>
                <div class="mb-2">
                    <strong>Program:</strong><br>
                    {{ $program->name }}
                </div>
                <div class="mb-2">
                    <strong>Duration:</strong><br>
                    {{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}
                </div>
                <div class="mb-2">
                    <strong>Status:</strong><br>
                    @if($program->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($program->status === 'completed')
                        <span class="badge bg-secondary">Completed</span>
                    @else
                        <span class="badge bg-warning">Inactive</span>
                    @endif
                </div>
                <div class="mb-2">
                    <strong>Location:</strong><br>
                    {{ $program->location ?? 'Not specified' }}
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h6>
                <ul class="small text-muted mb-0">
                    <li>Choose a clear and descriptive topic</li>
                    <li>Set realistic duration for the session</li>
                    <li>Specify location details if different from program location</li>
                    <li>Add notes for any special requirements or materials needed</li>
                </ul>
            </div>
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
