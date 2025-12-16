@extends('layouts.app')

@section('title', 'Session Attendance - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coordinator.sessions', $session->program_id) }}">{{ $session->program->name }}</a></li>
            <li class="breadcrumb-item active">Attendance</li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-user-check"></i> Session Attendance</h2>
    <p class="text-muted">{{ $session->topic }}</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="mb-3"><i class="fas fa-info-circle"></i> Session Details</h5>
                        <div class="mb-2">
                            <strong>Date & Time:</strong> {{ $session->session_date->format('M d, Y h:i A') }}
                        </div>
                        <div class="mb-2">
                            <strong>Location:</strong> {{ $session->location ?? 'TBD' }}
                        </div>
                        <div class="mb-2">
                            <strong>Duration:</strong> {{ $session->duration_minutes ?? 'N/A' }} minutes
                        </div>
                        @if($session->facilitator)
                            <div class="mb-2">
                                <strong>Facilitator:</strong> {{ $session->facilitator }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="display-4 mb-2">{{ $participants->count() }}</div>
                        <div>Total Participants</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard-check"></i> Mark Attendance</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('coordinator.attendance.record', $session->id) }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Participant</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participants as $index => $participant)
                                    @php
                                        $existingAttendance = $session->attendance->where('user_id', $participant->user_id)->first();
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $participant->user->name }}</strong>
                                            <input type="hidden" name="attendance[{{ $index }}][user_id]" value="{{ $participant->user_id }}">
                                        </td>
                                        <td>{{ $participant->user->email }}</td>
                                        <td>
                                            <select name="attendance[{{ $index }}][status]" class="form-select form-select-sm" required>
                                                <option value="present" {{ $existingAttendance && $existingAttendance->status == 'present' ? 'selected' : '' }}>
                                                    Present
                                                </option>
                                                <option value="absent" {{ $existingAttendance && $existingAttendance->status == 'absent' ? 'selected' : '' }}>
                                                    Absent
                                                </option>
                                                <option value="late" {{ $existingAttendance && $existingAttendance->status == 'late' ? 'selected' : '' }}>
                                                    Late
                                                </option>
                                                <option value="excused" {{ $existingAttendance && $existingAttendance->status == 'excused' ? 'selected' : '' }}>
                                                    Excused
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="attendance[{{ $index }}][notes]" 
                                                   class="form-control form-control-sm" 
                                                   placeholder="Optional notes"
                                                   value="{{ $existingAttendance->notes ?? '' }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-muted mb-0">No participants registered for this program</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($participants->count() > 0)
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Attendance
                            </button>
                            <a href="{{ route('coordinator.sessions', $session->program_id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Sessions
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-chart-pie"></i> Attendance Summary</h5>
                <hr>
                @php
                    $presentCount = $session->attendance->where('status', 'present')->count();
                    $absentCount = $session->attendance->where('status', 'absent')->count();
                    $lateCount = $session->attendance->where('status', 'late')->count();
                    $excusedCount = $session->attendance->where('status', 'excused')->count();
                    $totalRecorded = $session->attendance->count();
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-check-circle text-success"></i> Present</span>
                        <strong>{{ $presentCount }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $participants->count() > 0 ? ($presentCount / $participants->count() * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-times-circle text-danger"></i> Absent</span>
                        <strong>{{ $absentCount }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" role="progressbar" 
                             style="width: {{ $participants->count() > 0 ? ($absentCount / $participants->count() * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-clock text-warning"></i> Late</span>
                        <strong>{{ $lateCount }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: {{ $participants->count() > 0 ? ($lateCount / $participants->count() * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-exclamation-circle text-info"></i> Excused</span>
                        <strong>{{ $excusedCount }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" role="progressbar" 
                             style="width: {{ $participants->count() > 0 ? ($excusedCount / $participants->count() * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total Recorded:</strong>
                    <strong>{{ $totalRecorded }} / {{ $participants->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-lightbulb"></i> Quick Tips</h6>
                <ul class="small text-muted mb-0">
                    <li>Mark all participants before saving</li>
                    <li>Use "Late" for participants who arrived after start time</li>
                    <li>Use "Excused" for pre-approved absences</li>
                    <li>Add notes for any special circumstances</li>
                    <li>You can update attendance records later if needed</li>
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
