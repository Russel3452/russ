@extends('layouts.app')

@section('title', 'Create Program - Admin')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.programs') }}">Programs</a></li>
            <li class="breadcrumb-item active">Create Program</li>
        </ol>
    </nav>
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-plus-circle"></i> Create New Program</h2>
    <p class="text-muted">Add a new wellness program to the system</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Program Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.programs.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="fitness" {{ old('category') == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="nutrition" {{ old('category') == 'nutrition' ? 'selected' : '' }}>Nutrition</option>
                                <option value="mental health" {{ old('category') == 'mental health' ? 'selected' : '' }}>Mental Health</option>
                                <option value="wellness" {{ old('category') == 'wellness' ? 'selected' : '' }}>Wellness</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="coordinator_id" class="form-label">Coordinator <span class="text-danger">*</span></label>
                            <select class="form-select @error('coordinator_id') is-invalid @enderror" id="coordinator_id" name="coordinator_id" required>
                                <option value="">Select a coordinator</option>
                                @foreach($coordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}" {{ old('coordinator_id') == $coordinator->id ? 'selected' : '' }}>
                                        {{ $coordinator->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coordinator_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="enrollment_deadline" class="form-label">Enrollment Deadline <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('enrollment_deadline') is-invalid @enderror" id="enrollment_deadline" name="enrollment_deadline" value="{{ old('enrollment_deadline') }}" required>
                        <small class="form-text text-muted">Last date for participants to enroll</small>
                        @error('enrollment_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="e.g., 8 weeks, 3 months">
                            <small class="form-text text-muted">Optional: Describe the program duration</small>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                            <small class="form-text text-muted">Maximum number of participants</small>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g., Main Gym, Conference Room A">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.programs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Information</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3">Program Categories</h6>
                
                <div class="mb-3">
                    <span class="badge" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 15px;">
                        <i class="fas fa-dumbbell"></i> Fitness
                    </span>
                    <p class="text-muted small mt-2">Physical exercise and training programs</p>
                </div>

                <div class="mb-3">
                    <span class="badge" style="background: #56ab2f; color: white; padding: 6px 12px; border-radius: 15px;">
                        <i class="fas fa-apple-alt"></i> Nutrition
                    </span>
                    <p class="text-muted small mt-2">Diet and nutrition guidance programs</p>
                </div>

                <div class="mb-3">
                    <span class="badge" style="background: #9b59b6; color: white; padding: 6px 12px; border-radius: 15px;">
                        <i class="fas fa-brain"></i> Mental Health
                    </span>
                    <p class="text-muted small mt-2">Mental wellness and counseling programs</p>
                </div>

                <div class="mb-3">
                    <span class="badge" style="background: #f2994a; color: white; padding: 6px 12px; border-radius: 15px;">
                        <i class="fas fa-spa"></i> Wellness
                    </span>
                    <p class="text-muted small mt-2">General wellness and lifestyle programs</p>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Tips</h6>
                <ul class="text-muted small">
                    <li>Choose a descriptive program name</li>
                    <li>Provide detailed description for participants</li>
                    <li>Assign an active coordinator</li>
                    <li>Set realistic participant limits</li>
                    <li>Include location for in-person programs</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
