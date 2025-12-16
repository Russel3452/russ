@extends('layouts.app')

@section('title', 'Browse Programs')

@section('content')
<div class="mb-4 fade-in">
    <h2 class="fw-bold"><i class="fas fa-list"></i> Available Programs</h2>
    <p class="text-muted">Browse and register for health and wellness programs</p>
</div>

<div class="row g-4">
    @forelse($programs as $program)
        <div class="col-md-4">
            <div class="card program-card">
                <div class="card-body program-card-body">
                    <span class="badge badge-primary mb-2">{{ $program->category }}</span>
                    <h5 class="fw-bold">{{ $program->name }}</h5>
                    <p class="text-muted">{{ Str::limit($program->description, 100) }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $program->coordinator->name }}<br>
                            <i class="fas fa-calendar"></i> {{ $program->start_date->format('M d') }} - {{ $program->end_date->format('M d, Y') }}<br>
                            <i class="fas fa-users"></i> {{ $program->enrolled_count }}/{{ $program->capacity }} enrolled
                        </small>
                    </div>

                    <div class="progress mb-3">
                        <div class="progress-bar" style="width: {{ ($program->enrolled_count / $program->capacity) * 100 }}%"></div>
                    </div>

                    <div class="program-card-footer">
                        @php
                            $userRegistration = $program->registrations->first();
                            $isWithdrawn = $userRegistration && $userRegistration->status === 'withdrawn';
                        @endphp
                        
                        @if($isWithdrawn)
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle"></i> Previously Withdrawn
                            </span>
                            <small class="text-muted d-block mt-1">You can register again</small>
                        @endif
                        
                        @if($program->isEnrollmentOpen())
                            <span class="badge badge-success">Open for Enrollment</span>
                            <small class="text-muted d-block mt-1">Deadline: {{ $program->enrollment_deadline->format('M d, Y') }}</small>
                        @else
                            <span class="badge badge-danger">Enrollment Closed</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('participant.programs.show', $program->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No programs available at the moment</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $programs->links() }}
</div>
@endsection
