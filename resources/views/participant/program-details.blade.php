@extends('layouts.app')

@section('title', $program->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('participant.programs') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Programs
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $program->name }}</h4>
            </div>
            <div class="card-body">
                <span class="badge badge-primary mb-3">{{ $program->category }}</span>
                
                <h5 class="fw-bold">Description</h5>
                <p>{{ $program->description }}</p>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold"><i class="fas fa-user"></i> Coordinator</h6>
                        <p class="mb-0">{{ $program->coordinator->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold"><i class="fas fa-calendar"></i> Duration</h6>
                        <p class="mb-0">{{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold"><i class="fas fa-clock"></i> Enrollment Deadline</h6>
                        <p class="mb-0">{{ $program->enrollment_deadline->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold"><i class="fas fa-users"></i> Capacity</h6>
                        <p class="mb-0">{{ $program->enrolled_count }} / {{ $program->capacity }}</p>
                    </div>
                </div>

                <div class="progress mb-3">
                    <div class="progress-bar" style="width: {{ ($program->enrolled_count / $program->capacity) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Program Sessions</h5>
            </div>
            <div class="card-body">
                @forelse($program->sessions as $session)
                    <div class="card mb-2">
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $session->topic }}</h6>
                            <p class="mb-1">{{ $session->description }}</p>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> {{ $session->session_date->format('M d, Y h:i A') }}
                                @if($session->facilitator)
                                    | <i class="fas fa-user"></i> {{ $session->facilitator }}
                                @endif
                                @if($session->location)
                                    | <i class="fas fa-map-marker-alt"></i> {{ $session->location }}
                                @endif
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No sessions scheduled yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Register</h5>
            </div>
            <div class="card-body">
                @if($isRegistered)
                    <div class="alert alert-info">
                        <i class="fas fa-check-circle"></i> You are already registered for this program
                    </div>
                    <a href="{{ route('participant.my-programs') }}" class="btn btn-primary w-100">
                        View My Programs
                    </a>
                @elseif($program->isEnrollmentOpen())
                    @if($isWithdrawn)
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle"></i> You previously withdrew from this program. You can register again.
                        </div>
                    @endif
                    <form action="{{ route('participant.programs.register', $program->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="health_goals" class="form-label">Health Goals</label>
                            <textarea class="form-control" id="health_goals" name="health_goals" rows="3" placeholder="What do you hope to achieve?"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="personal_notes" class="form-label">Personal Notes</label>
                            <textarea class="form-control" id="personal_notes" name="personal_notes" rows="2" placeholder="Any additional information"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i> {{ $isWithdrawn ? 'Re-register' : 'Register Now' }}
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Enrollment is closed for this program
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
