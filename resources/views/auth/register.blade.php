@extends('layouts.app')

@section('title', 'Register - Health & Wellness Tracker')

@push('styles')
<style>
    body {
        background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(30, 60, 114, 0.85) 0%, rgba(42, 82, 152, 0.85) 100%);
        opacity: 0.85;
        z-index: -1;
    }
    
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    
    .btn-outline-primary {
        background: rgba(255, 255, 255, 0.9);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11 col-lg-10">
        <div class="card fade-in" style="border-radius: 20px; overflow: hidden;">
            <div class="row g-0">
                <!-- Left Side - Logo & Branding -->
                <div class="col-md-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 3rem 2rem; position: relative;">
                    <div class="mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Home
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="height: calc(100% - 50px);">
                        <div class="text-center text-white">
                            <div class="mb-4">
                                <i class="fas fa-heartbeat" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Join Us Today</h3>
                            <p class="mb-0" style="font-size: 1rem; opacity: 0.9;">Start your wellness journey with us</p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="col-md-8">
                    <div class="p-4">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold" style="color: #1e3c72;">Create Your Account</h4>
                            <p class="text-muted">Join our health & wellness community</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-user"></i> Full Name *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required
                                           placeholder="Enter your full name"
                                           style="border-radius: 8px;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope"></i> Email Address *
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required
                                           placeholder="Enter your email"
                                           style="border-radius: 8px;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock"></i> Password *
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required
                                           placeholder="Min 8 characters"
                                           style="border-radius: 8px;">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="fas fa-lock"></i> Confirm Password *
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           placeholder="Confirm password"
                                           style="border-radius: 8px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">
                                        <i class="fas fa-phone"></i> Phone Number
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           placeholder="Your phone number"
                                           style="border-radius: 8px;">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label fw-semibold">
                                        <i class="fas fa-calendar"></i> Date of Birth
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" 
                                           name="date_of_birth" 
                                           value="{{ old('date_of_birth') }}"
                                           style="border-radius: 8px;">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label fw-semibold">
                                    <i class="fas fa-venus-mars"></i> Gender
                                </label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender"
                                        style="border-radius: 8px;">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt"></i> Address
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="2"
                                          placeholder="Your address"
                                          style="border-radius: 8px;">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="health_conditions" class="form-label fw-semibold">
                                    <i class="fas fa-notes-medical"></i> Health Conditions (Optional)
                                </label>
                                <textarea class="form-control @error('health_conditions') is-invalid @enderror" 
                                          id="health_conditions" 
                                          name="health_conditions" 
                                          rows="2"
                                          placeholder="Any health conditions we should know"
                                          style="border-radius: 8px;">{{ old('health_conditions') }}</textarea>
                                @error('health_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 0.75rem; border-radius: 10px; font-size: 1.1rem;">
                                <i class="fas fa-user-plus"></i> Register
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Already have an account? 
                                    <a href="{{ route('login') }}" class="text-primary fw-bold">Login here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
