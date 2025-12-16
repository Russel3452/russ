@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
<style>
    .chart-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .chart-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .chart-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .chart-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }
    .chart-description {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0.25rem 0 0 0;
    }
    .chart-body {
        padding: 1.5rem;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
    <p class="text-muted">System Overview and Statistics</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $stats['total_users'] }}</div>
                <div class="stat-card-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $stats['total_programs'] }}</div>
                <div class="stat-card-label">Total Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $stats['active_programs'] }}</div>
                <div class="stat-card-label">Active Programs</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon info">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-card-content">
                <div class="stat-card-value">{{ $stats['total_registrations'] }}</div>
                <div class="stat-card-label">Total Registrations</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-line"></i> User Growth Trend</h3>
                <p class="chart-description">Monthly user registrations over the last 6 months</p>
            </div>
            <div class="chart-body">
                <div class="chart-container">
                    <canvas id="userLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Programs Created</h3>
                <p class="chart-description">Last 6 months</p>
            </div>
            <div class="chart-body">
                <div class="chart-container">
                    <canvas id="programBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-area"></i> Registration Activity</h3>
                <p class="chart-description">Program registrations trend over time</p>
            </div>
            <div class="chart-body">
                <div class="chart-container" style="height: 350px;">
                    <canvas id="registrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Activities</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->user->name ?? 'System' }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($activity->action) }}</span></td>
                                    <td>{{ $activity->model }}</td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-muted mb-0">No recent activities</p>
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

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Create New User
                    </a>
                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog"></i> System Settings
                    </a>
                    <a href="{{ route('admin.audit-logs') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history"></i> View Audit Logs
                    </a>
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar"></i> Generate Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Chart.js loaded:', typeof Chart !== 'undefined');
        console.log('User Chart Data:', @json($userChartData));
        console.log('User Chart Labels:', @json($userChartLabels));
        console.log('Program Chart Data:', @json($programChartData));
        console.log('Registration Chart Data:', @json($registrationChartData));
    });

    // shadcn-inspired color palette
    const colors = {
        primary: '#1e3c72',
        secondary: '#2a5298',
        success: '#10b981',
        warning: '#f59e0b',
        info: '#3b82f6',
        muted: '#64748b',
        background: '#f8fafc',
        border: '#e2e8f0'
    };

    // Wait for DOM to be ready
    window.addEventListener('load', function() {
        // Chart.js default config for shadcn look
        Chart.defaults.font.family = "'Inter', 'Segoe UI', 'system-ui', sans-serif";
        Chart.defaults.color = colors.muted;
        Chart.defaults.borderColor = colors.border;

        // User Growth Line Chart
        const userLineCtx = document.getElementById('userLineChart');
        if (!userLineCtx) {
            console.error('userLineChart canvas not found');
            return;
        }
        const userLineChart = new Chart(userLineCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($userChartLabels),
                datasets: [{
                    label: 'New Users',
                    data: @json($userChartData),
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(30, 60, 114, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: colors.primary,
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
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
                        backgroundColor: '#fff',
                        titleColor: colors.primary,
                        bodyColor: colors.muted,
                        borderColor: colors.border,
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.parsed.y + ' users';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    grid: {
                        color: colors.border,
                        drawBorder: false
                    },
                    ticks: {
                        precision: 0,
                        padding: 10
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // Program Bar Chart
        const programBarCtx = document.getElementById('programBarChart');
        if (!programBarCtx) {
            console.error('programBarChart canvas not found');
            return;
        }
        const programBarChart = new Chart(programBarCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($programChartLabels),
                datasets: [{
                    label: 'Programs',
                    data: @json($programChartData),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: colors.success,
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false
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
                        backgroundColor: '#fff',
                        titleColor: colors.primary,
                        bodyColor: colors.muted,
                        borderColor: colors.border,
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.parsed.y + ' programs';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.border,
                        drawBorder: false
                    },
                    ticks: {
                        precision: 0,
                        padding: 10
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // Registration Activity Chart (Combined Line + Bar)
        const registrationCtx = document.getElementById('registrationChart');
        if (!registrationCtx) {
            console.error('registrationChart canvas not found');
            return;
        }
        const registrationChart = new Chart(registrationCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($registrationChartLabels),
                datasets: [{
                    label: 'Registrations',
                    data: @json($registrationChartData),
                    borderColor: colors.info,
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.info,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: colors.info,
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 13,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: colors.primary,
                        bodyColor: colors.muted,
                        borderColor: colors.border,
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.parsed.y + ' registrations';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.border,
                        drawBorder: false
                    },
                    ticks: {
                        precision: 0,
                        padding: 10
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                        },
                        border: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endsection
