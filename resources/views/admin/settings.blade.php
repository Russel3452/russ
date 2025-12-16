@extends('layouts.app')

@section('title', 'Settings - Admin')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-cog"></i> System Settings</h2>
    <p class="text-muted">Manage application settings and configurations</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-sliders-h"></i> General Settings</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="app_name" class="form-label">Application Name</label>
                        <input type="text" class="form-control" id="app_name" name="app_name" value="{{ $settings['app_name'] ?? 'Health & Wellness Tracker' }}">
                    </div>

                    <div class="mb-3">
                        <label for="app_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="app_email" name="app_email" value="{{ $settings['app_email'] ?? 'admin@healthwellness.com' }}">
                    </div>

                    <div class="mb-3">
                        <label for="app_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" id="app_phone" name="app_phone" value="{{ $settings['app_phone'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="timezone" class="form-label">Timezone</label>
                        <select class="form-select" id="timezone" name="timezone">
                            <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (ET)</option>
                            <option value="America/Chicago" {{ ($settings['timezone'] ?? '') == 'America/Chicago' ? 'selected' : '' }}>Central Time (CT)</option>
                            <option value="America/Denver" {{ ($settings['timezone'] ?? '') == 'America/Denver' ? 'selected' : '' }}>Mountain Time (MT)</option>
                            <option value="America/Los_Angeles" {{ ($settings['timezone'] ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (PT)</option>
                            <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">Program Settings</h6>

                    <div class="mb-3">
                        <label for="max_active_programs" class="form-label">Max Active Programs <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('max_active_programs') is-invalid @enderror" id="max_active_programs" name="max_active_programs" value="{{ $settings['max_active_programs'] ?? 10 }}" min="1" required>
                        <small class="form-text text-muted">Maximum number of active programs allowed</small>
                        @error('max_active_programs')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="wellness_categories" class="form-label">Wellness Categories <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('wellness_categories') is-invalid @enderror" id="wellness_categories" name="wellness_categories" rows="3" required>{{ $settings['wellness_categories'] ?? 'fitness,nutrition,mental health,wellness' }}</textarea>
                        <small class="form-text text-muted">Comma-separated list of wellness categories</small>
                        @error('wellness_categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="metric_templates" class="form-label">Metric Templates <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('metric_templates') is-invalid @enderror" id="metric_templates" name="metric_templates" rows="4" required>{{ $settings['metric_templates'] ?? 'weight,bmi,blood_pressure,heart_rate,steps,sleep_hours' }}</textarea>
                        <small class="form-text text-muted">Comma-separated list of metric templates for tracking</small>
                        @error('metric_templates')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">Notification Settings</h6>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ ($settings['email_notifications'] ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notifications">
                                Enable Email Notifications
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="session_reminders" name="session_reminders" value="1" {{ ($settings['session_reminders'] ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="session_reminders">
                                Send Session Reminders
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reminder_hours" class="form-label">Reminder Hours Before Session</label>
                        <input type="number" class="form-control" id="reminder_hours" name="reminder_hours" value="{{ $settings['reminder_hours'] ?? 24 }}" min="1">
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">Security Settings</h6>

                    <div class="mb-3">
                        <label for="session_timeout" class="form-label">Session Timeout (minutes)</label>
                        <input type="number" class="form-control" id="session_timeout" name="session_timeout" value="{{ $settings['session_timeout'] ?? 120 }}" min="5">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="require_strong_password" name="require_strong_password" value="1" {{ ($settings['require_strong_password'] ?? '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="require_strong_password">
                                Require Strong Passwords
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> System Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Version</label>
                    <p class="mb-0 fw-bold">1.0.0</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Laravel Version</label>
                    <p class="mb-0 fw-bold">{{ app()->version() }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">PHP Version</label>
                    <p class="mb-0 fw-bold">{{ PHP_VERSION }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Environment</label>
                    <p class="mb-0">
                        <span class="badge" style="background: {{ app()->environment('production') ? '#56ab2f' : '#f2994a' }}; color: white; padding: 5px 10px; border-radius: 15px;">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Important</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    <i class="fas fa-info-circle text-primary"></i> Changes to these settings will affect all users and may require them to log in again.
                </p>
                <p class="text-muted small mb-0">
                    <i class="fas fa-shield-alt text-success"></i> All settings are securely stored and encrypted where necessary.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
