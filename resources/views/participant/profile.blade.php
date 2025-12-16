@extends('layouts.app')

@section('title', 'Profile - Participant')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold" style="color: #1e3c72;"><i class="fas fa-user-circle"></i> My Profile</h2>
    <p class="text-muted">Manage your account information and settings</p>
</div>

<div class="row g-4">
    <!-- Profile Information Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 120px; height: 120px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                <p class="text-muted mb-2">{{ ucfirst(auth()->user()->role) }}</p>
                <p class="text-muted mb-3">
                    <i class="fas fa-envelope"></i> {{ auth()->user()->email }}
                </p>
                <span class="badge" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                    Active Member
                </span>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Account Stats</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Member Since</span>
                    <strong>{{ auth()->user()->created_at->format('M d, Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Last Login</span>
                    <strong>{{ auth()->user()->updated_at->diffForHumans() }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Status</span>
                    <span class="badge" style="background-color: #10b981;">{{ ucfirst(auth()->user()->status ?? 'active') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details & Update Form -->
    <div class="col-lg-8">
        <!-- Update Profile Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-edit"></i> Profile Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('participant.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', auth()->user()->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst(auth()->user()->role) }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               value="{{ old('date_of_birth', auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('Y-m-d') : '') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('participant.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Password must be at least 8 characters long.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
