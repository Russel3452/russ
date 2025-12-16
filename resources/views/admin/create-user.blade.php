@extends('layouts.app')

@section('title', 'Create User - Admin')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="breadcrumb-item active">Create User</li>
        </ol>
    </nav>
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-user-plus"></i> Create New User</h2>
    <p class="text-muted">Add a new user to the system</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> User Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        <small class="form-text text-muted">Password must be at least 8 characters long</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Select a role</option>
                            <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Participant</option>
                            <option value="coordinator" {{ old('role') == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create User
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
                <h6 class="fw-bold mb-3">Role Descriptions</h6>
                
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-primary me-2">
                            <i class="fas fa-user-shield"></i> Admin
                        </span>
                    </div>
                    <p class="text-muted small">Full system access including user management, settings, and reports.</p>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-warning me-2">
                            <i class="fas fa-user-tie"></i> Coordinator
                        </span>
                    </div>
                    <p class="text-muted small">Can manage programs, sessions, attendance, and participant progress.</p>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-info me-2">
                            <i class="fas fa-user"></i> Participant
                        </span>
                    </div>
                    <p class="text-muted small">Can browse and register for programs, track attendance and progress.</p>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Password Requirements</h6>
                <ul class="text-muted small">
                    <li>Minimum 8 characters</li>
                    <li>Must match confirmation</li>
                    <li>User will be able to change it after first login</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
