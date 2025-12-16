<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Health & Wellness Tracker</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>❤️</text></svg>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="/css/custom.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            padding-top: 0;
            overflow-x: hidden;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(30, 60, 114, 0.85) 0%, rgba(42, 82, 152, 0.85) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); }
            50% { transform: scale(1.05); box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3); }
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.95);
            max-width: 800px;
            margin: 0 auto 3rem;
            line-height: 1.8;
        }
        
        .btn-hero-primary {
            background: white;
            color: #1e3c72;
            padding: 1.2rem 3rem;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border: none;
        }
        
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.4);
            background: #f8f9fa;
            color: #1e3c72;
        }
        
        .btn-hero-secondary {
            background: #1e3c72;
            color: white;
            padding: 1.2rem 3rem;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            border: 3px solid white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-hero-secondary:hover {
            transform: translateY(-3px);
            background: white;
            color: #1e3c72;
        }
        
        /* Programs Carousel Section */
        .programs-carousel-section {
            padding: 5rem 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #64748b;
        }
        
        .carousel-track {
            display: flex;
            gap: 2rem;
            animation: scroll 30s linear infinite;
            width: max-content;
        }
        
        .carousel-wrapper {
            overflow: hidden;
            padding: 2rem 0;
        }
        
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .program-card {
            background: white;
            border-radius: 20px;
            width: 350px;
            flex-shrink: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }
        
        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(30, 60, 114, 0.2);
            border-color: #2a5298;
        }
        
        .program-card-header {
            padding: 2rem;
            color: white;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .program-card-header.color-1 {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .program-card-header.color-2 {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        }
        
        .program-card-header.color-3 {
            background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%);
        }
        
        .program-card-header.color-4 {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        }
        
        .program-card-header.color-5 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .program-card-header.color-6 {
            background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        }
        
        .program-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .program-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .program-category {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .program-card-body {
            padding: 1.5rem;
        }
        
        .program-description {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .program-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .program-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(30, 60, 114, 0.15);
            border-color: #2a5298;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon.feature-color-1 {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
        }
        
        .feature-icon.feature-color-2 {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            box-shadow: 0 10px 30px rgba(86, 171, 47, 0.3);
        }
        
        .feature-icon.feature-color-3 {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            box-shadow: 0 10px 30px rgba(238, 9, 121, 0.3);
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.8;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .stat-box {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }
        
        .stat-label {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: white;
            text-align: center;
        }
        
        .cta-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }
        
        .cta-text {
            font-size: 1.3rem;
            color: #64748b;
            margin-bottom: 3rem;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .program-card {
                width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <div class="mb-5">
                    <div class="hero-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
                <h1 class="hero-title">
                    Transform Your Health Journey
                </h1>
                <p class="hero-subtitle">
                    Join our comprehensive wellness platform to track your progress, participate in programs, 
                    and achieve your health goals with expert guidance and community support
                </p>
                
                <div class="d-flex gap-4 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-hero-primary">
                        <i class="fas fa-user-plus me-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-hero-secondary">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Carousel Section -->
    <section class="programs-carousel-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Wellness Programs</h2>
                <p class="section-subtitle">Discover programs designed to help you achieve your health and wellness goals</p>
            </div>
        </div>
        
        <div class="carousel-wrapper">
            <div class="carousel-track">
                @forelse($programs as $index => $program)
                    <div class="program-card">
                        <div class="program-card-header color-{{ ($index % 6) + 1 }}">
                            <div class="program-icon">
                                @php
                                    $icons = [
                                        'fitness' => 'fa-dumbbell',
                                        'nutrition' => 'fa-apple-alt',
                                        'mental health' => 'fa-brain',
                                        'yoga' => 'fa-spa',
                                        'cardio' => 'fa-running',
                                        'wellness' => 'fa-leaf',
                                    ];
                                    $category = strtolower($program->category);
                                    $icon = $icons[$category] ?? 'fa-heartbeat';
                                @endphp
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="program-title">{{ $program->name }}</div>
                            <div class="program-category">
                                <i class="fas fa-tag me-1"></i>{{ $program->category }}
                            </div>
                        </div>
                        <div class="program-card-body">
                            <p class="program-description">
                                {{ Str::limit($program->description, 120) }}
                            </p>
                            <div class="program-meta">
                                <div class="program-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="program-meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $program->coordinator->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-card">
                        <div class="program-card-header color-1">
                            <div class="program-icon"><i class="fas fa-dumbbell"></i></div>
                            <div class="program-title">Sample Fitness Program</div>
                            <div class="program-category"><i class="fas fa-tag me-1"></i>Fitness</div>
                        </div>
                        <div class="program-card-body">
                            <p class="program-description">Join our comprehensive fitness program designed for all levels.</p>
                            <div class="program-meta">
                                <div class="program-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Coming Soon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                
                <!-- Duplicate for seamless loop -->
                @foreach($programs as $index => $program)
                    <div class="program-card">
                        <div class="program-card-header color-{{ ($index % 6) + 1 }}">
                            <div class="program-icon">
                                @php
                                    $icons = [
                                        'fitness' => 'fa-dumbbell',
                                        'nutrition' => 'fa-apple-alt',
                                        'mental health' => 'fa-brain',
                                        'yoga' => 'fa-spa',
                                        'cardio' => 'fa-running',
                                        'wellness' => 'fa-leaf',
                                    ];
                                    $category = strtolower($program->category);
                                    $icon = $icons[$category] ?? 'fa-heartbeat';
                                @endphp
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="program-title">{{ $program->name }}</div>
                            <div class="program-category">
                                <i class="fas fa-tag me-1"></i>{{ $program->category }}
                            </div>
                        </div>
                        <div class="program-card-body">
                            <p class="program-description">
                                {{ Str::limit($program->description, 120) }}
                            </p>
                            <div class="program-meta">
                                <div class="program-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="program-meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $program->coordinator->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Platform Features</h2>
                <p class="section-subtitle">Everything you need to succeed in your wellness journey</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon feature-color-1">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="feature-title">Program Management</h3>
                        <p class="feature-description">
                            Browse and enroll in diverse wellness programs tailored to your goals. 
                            Track your participation and stay committed to your health objectives.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon feature-color-2">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="feature-title">Attendance Tracking</h3>
                        <p class="feature-description">
                            Never miss a session with our easy check-in system. Maintain a complete 
                            record of your participation and monitor your consistency.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon feature-color-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Progress Analytics</h3>
                        <p class="feature-description">
                            Visualize your health journey with detailed metrics and reports. 
                            Set goals, track improvements, and celebrate your achievements.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Active Programs</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number">1,000+</div>
                        <div class="stat-label">Happy Members</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Expert Coordinators</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Ready to Begin Your Wellness Journey?</h2>
            <p class="cta-text">
                Join thousands of members who have transformed their health with our platform
            </p>
            <a href="{{ route('register') }}" class="btn btn-hero-primary">
                <i class="fas fa-rocket me-2"></i>Start Your Free Journey Today
            </a>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
