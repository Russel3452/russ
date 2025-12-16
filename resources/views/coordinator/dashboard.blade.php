@extends('layouts.app')

@section('title', 'Dashboard - Coordinator')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-tachometer-alt"></i> Coordinator Dashboard</h2>
    <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $programs->count() }}</div>
                <div class="stat-card-label">Total Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $programs->sum('registrations_count') }}</div>
                <div class="stat-card-label">Total Participants</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $upcomingSessions->count() }}</div>
                <div class="stat-card-label">Upcoming Sessions</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $programs->where('status', 'active')->count() }}</div>
                <div class="stat-card-label">Active Programs</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Participants by Program</h5>
            </div>
            <div class="card-body">
                <canvas id="participantsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Program Status Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Upcoming Sessions</h5>
                <a href="{{ route('coordinator.programs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Program
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Session</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingSessions as $session)
                                <tr>
                                    <td>{{ $session->program->name }}</td>
                                    <td>{{ $session->topic }}</td>
                                    <td>{{ $session->session_date->format('M d, Y h:i A') }}</td>
                                    <td>{{ $session->location ?? 'TBD' }}</td>
                                    <td>
                                        <a href="{{ route('coordinator.attendance', $session->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-check"></i> Attendance
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-muted mb-0">No upcoming sessions</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
<script>
    // Participants by Program Pie Chart
    const participantsCtx = document.getElementById('participantsChart').getContext('2d');
    
    // Filter programs with participants
    const programsData = {!! json_encode($programs->filter(function($p) { return $p->registrations_count > 0; })->values()->map(function($p) { return ['name' => $p->name, 'count' => $p->registrations_count]; })->toArray()) !!};
    const programLabels = programsData.map(p => p.name);
    const programCounts = programsData.map(p => p.count);
    
    const participantsChart = new Chart(participantsCtx, {
        type: 'pie',
        data: {
            labels: programLabels,
            datasets: [{
                label: 'Participants',
                data: programCounts,
                backgroundColor: [
                    '#1e3c72',
                    '#2a5298',
                    '#56ab2f',
                    '#3498db',
                    '#f2994a',
                    '#9b59b6',
                    '#f1c40f',
                    '#e74c3c'
                ],
                borderColor: '#ffffff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 60, 114, 0.9)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed + ' participants';
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Program Status Line Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    
    const programStatuses = {!! json_encode($programs->groupBy('status')->map->count()->toArray()) !!};
    const statusLabels = Object.keys(programStatuses).map(status => status.charAt(0).toUpperCase() + status.slice(1));
    const statusData = Object.values(programStatuses);
    
    const statusChart = new Chart(statusCtx, {
        type: 'line',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Programs',
                data: statusData,
                borderColor: 'rgba(42, 82, 152, 1)',
                backgroundColor: 'rgba(42, 82, 152, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(42, 82, 152, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 60, 114, 0.9)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
