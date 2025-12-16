@extends('layouts.app')

@section('title', 'Edit Program - Coordinator')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coordinator.programs') }}">My Programs</a></li>
            <li class="breadcrumb-item active">Edit {{ $program->name }}</li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-edit"></i> Edit Program</h2>
    <p class="text-muted">Update program information</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('coordinator.programs.update', $program->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $program->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  required>{{ old('description', $program->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Select a category</option>
                                    <option value="fitness" {{ old('category', $program->category) == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                    <option value="nutrition" {{ old('category', $program->category) == 'nutrition' ? 'selected' : '' }}>Nutrition</option>
                                    <option value="mental-health" {{ old('category', $program->category) == 'mental-health' ? 'selected' : '' }}>Mental Health</option>
                                    <option value="stress-management" {{ old('category', $program->category) == 'stress-management' ? 'selected' : '' }}>Stress Management</option>
                                    <option value="weight-management" {{ old('category', $program->category) == 'weight-management' ? 'selected' : '' }}>Weight Management</option>
                                    <option value="smoking-cessation" {{ old('category', $program->category) == 'smoking-cessation' ? 'selected' : '' }}>Smoking Cessation</option>
                                    <option value="chronic-disease" {{ old('category', $program->category) == 'chronic-disease' ? 'selected' : '' }}>Chronic Disease Management</option>
                                    <option value="general-wellness" {{ old('category', $program->category) == 'general-wellness' ? 'selected' : '' }}>General Wellness</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" 
                                       name="capacity" 
                                       value="{{ old('capacity', $program->capacity) }}" 
                                       min="{{ $program->enrolled_count }}" 
                                       required>
                                <small class="text-muted">Current enrollments: {{ $program->enrolled_count }}</small>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="{{ old('start_date', $program->start_date->format('Y-m-d')) }}" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="{{ old('end_date', $program->end_date->format('Y-m-d')) }}" 
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="enrollment_deadline" class="form-label">Enrollment Deadline <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('enrollment_deadline') is-invalid @enderror" 
                               id="enrollment_deadline" 
                               name="enrollment_deadline" 
                               value="{{ old('enrollment_deadline', $program->enrollment_deadline->format('Y-m-d')) }}" 
                               required>
                        <small class="text-muted">Must be before the start date</small>
                        @error('enrollment_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" 
                               class="form-control @error('location') is-invalid @enderror" 
                               id="location" 
                               name="location" 
                               value="{{ old('location', $program->location) }}" 
                               placeholder="e.g., Community Center, Room 101">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="draft" {{ old('status', $program->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $program->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $program->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Program
                        </button>
                        <a href="{{ route('coordinator.programs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle"></i> Program Statistics</h5>
                <hr>
                <div class="mb-2">
                    <strong>Current Enrollments:</strong><br>
                    {{ $program->enrolled_count }} / {{ $program->capacity }}
                </div>
                <div class="mb-2">
                    <strong>Sessions:</strong><br>
                    {{ $program->sessions()->count() }}
                </div>
                <div class="mb-2">
                    <strong>Created:</strong><br>
                    {{ $program->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-exclamation-triangle"></i> Important Notes</h6>
                <ul class="small text-muted mb-0">
                    <li class="mb-2">Capacity cannot be set below current enrollment count</li>
                    <li class="mb-2">End date must be after start date</li>
                    <li class="mb-2">Enrollment deadline must be before start date</li>
                    <li class="mb-2">Setting status to "Cancelled" will prevent new enrollments</li>
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
