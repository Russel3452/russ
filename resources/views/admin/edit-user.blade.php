@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-user-edit"></i> Edit User</h2>
    <p class="text-muted">Update user information</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> User Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="form-text text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="">Select a role</option>
                            <option value="participant" {{ old('role', $user->role) == 'participant' ? 'selected' : '' }}>Participant</option>
                            <option value="coordinator" {{ old('role', $user->role) == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <small class="form-text text-muted">You cannot change your own role.</small>
                        @endif
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="status" value="{{ $user->status ?? 'active' }}">
                            <small class="form-text text-muted">You cannot change your own status.</small>
                        @endif
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-circle"></i> User Details</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; font-size: 2rem; font-weight: bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">User ID</small>
                    <p class="mb-0 fw-bold">{{ $user->id }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Current Role</small>
                    <p class="mb-0">
                        @if($user->role === 'admin')
                            <span class="badge badge-primary">
                                <i class="fas fa-user-shield"></i> Admin
                            </span>
                        @elseif($user->role === 'coordinator')
                            <span class="badge badge-warning">
                                <i class="fas fa-user-tie"></i> Coordinator
                            </span>
                        @else
                            <span class="badge badge-info">
                                <i class="fas fa-user"></i> Participant
                            </span>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Account Created</small>
                    <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0">{{ $user->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Information</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3">Password Update</h6>
                <p class="text-muted small">Leave the password field blank if you don't want to change it. If you enter a new password, it must be at least 8 characters long.</p>

                <hr>

                <h6 class="fw-bold mb-3">Role & Status</h6>
                <p class="text-muted small">You cannot modify your own role or status for security reasons.</p>
            </div>
        </div>
    </div>
</div>
@endsection
