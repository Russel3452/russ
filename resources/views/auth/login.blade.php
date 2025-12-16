@extends('layouts.app')

@section('title', 'Login - Health & Wellness Tracker')

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
    <div class="col-md-9 col-lg-8">
        <div class="card fade-in" style="border-radius: 20px; overflow: hidden;">
            <div class="row g-0">
                <!-- Left Side - Logo & Branding -->
                <div class="col-md-5" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 3rem; position: relative;">
                    <div class="mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Home
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="height: calc(100% - 50px);">
                        <div class="text-center text-white">
                            <div class="mb-4">
                                <i class="fas fa-heartbeat" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-3">Health & Wellness</h2>
                            <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9;">Your journey to a healthier life starts here</p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-md-7">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold" style="color: #1e3c72;">Welcome Back</h4>
                            <p class="text-muted">Please login to your account</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       placeholder="Enter your email"
                                       style="padding: 0.75rem; border-radius: 10px;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       placeholder="Enter your password"
                                       style="padding: 0.75rem; border-radius: 10px;">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 0.75rem; border-radius: 10px; font-size: 1.1rem;">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-primary fw-bold">Register here</a>
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
