@extends('layouts.app')

@section('title', 'Create Program - Coordinator')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-plus-circle"></i> Create New Program</h2>
    <p class="text-muted">Set up a new health and wellness program</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('coordinator.programs.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
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
                                  required>{{ old('description') }}</textarea>
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
                                    <option value="fitness" {{ old('category') == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                    <option value="nutrition" {{ old('category') == 'nutrition' ? 'selected' : '' }}>Nutrition</option>
                                    <option value="mental-health" {{ old('category') == 'mental-health' ? 'selected' : '' }}>Mental Health</option>
                                    <option value="stress-management" {{ old('category') == 'stress-management' ? 'selected' : '' }}>Stress Management</option>
                                    <option value="weight-management" {{ old('category') == 'weight-management' ? 'selected' : '' }}>Weight Management</option>
                                    <option value="smoking-cessation" {{ old('category') == 'smoking-cessation' ? 'selected' : '' }}>Smoking Cessation</option>
                                    <option value="chronic-disease" {{ old('category') == 'chronic-disease' ? 'selected' : '' }}>Chronic Disease Management</option>
                                    <option value="general-wellness" {{ old('category') == 'general-wellness' ? 'selected' : '' }}>General Wellness</option>
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
                                       value="{{ old('capacity', 30) }}" 
                                       min="1" 
                                       required>
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
                                       value="{{ old('start_date') }}" 
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
                                       value="{{ old('end_date') }}" 
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
                               value="{{ old('enrollment_deadline') }}" 
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
                               value="{{ old('location') }}" 
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
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        </select>
                        <small class="text-muted">Draft programs are not visible to participants</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Program
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-lightbulb"></i> Program Setup Tips</h5>
                <hr>
                <ul class="small text-muted mb-0">
                    <li class="mb-2">Choose a clear, descriptive name for your program</li>
                    <li class="mb-2">Write a detailed description to help participants understand the program goals</li>
                    <li class="mb-2">Select appropriate start and end dates based on your schedule</li>
                    <li class="mb-2">Set enrollment deadline at least a few days before start date</li>
                    <li class="mb-2">Consider realistic capacity based on resources available</li>
                    <li class="mb-2">Use "Draft" status while planning, then switch to "Active" when ready</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-info-circle"></i> Next Steps</h6>
                <p class="small text-muted mb-0">After creating the program, you can:</p>
                <ul class="small text-muted mb-0">
                    <li>Add sessions to the program schedule</li>
                    <li>Track participant registrations</li>
                    <li>Record attendance for each session</li>
                    <li>Monitor participant progress</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
