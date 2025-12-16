<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    $programs = \App\Models\Program::where('status', 'active')
        ->with('coordinator')
        ->latest()
        ->take(6)
        ->get();
    return view('welcome', compact('programs'));
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Participant routes
Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('dashboard');
    Route::get('/programs', [ParticipantController::class, 'programs'])->name('programs');
    Route::get('/programs/{id}', [ParticipantController::class, 'showProgram'])->name('programs.show');
    Route::post('/programs/{id}/register', [ParticipantController::class, 'register'])->name('programs.register');
    Route::get('/my-programs', [ParticipantController::class, 'myPrograms'])->name('my-programs');
    Route::get('/attendance', [ParticipantController::class, 'attendance'])->name('attendance');
    Route::post('/sessions/{id}/check-in', [ParticipantController::class, 'checkIn'])->name('check-in');
    Route::get('/progress/{id}', [ParticipantController::class, 'progress'])->name('progress');
    Route::post('/progress/{id}/update-goals', [ParticipantController::class, 'updateGoals'])->name('progress.update-goals');
    
    // Profile
    Route::get('/profile', [ParticipantController::class, 'profile'])->name('profile');
    Route::put('/profile', [ParticipantController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ParticipantController::class, 'updatePassword'])->name('profile.password');
});

// Coordinator routes
Route::middleware(['auth', 'role:coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', [CoordinatorController::class, 'dashboard'])->name('dashboard');
    
    // Overview Pages
    Route::get('/all-sessions', [CoordinatorController::class, 'allSessions'])->name('all-sessions');
    Route::get('/all-participants', [CoordinatorController::class, 'allParticipants'])->name('all-participants');
    
    // Programs
    Route::get('/programs', [CoordinatorController::class, 'programs'])->name('programs');
    Route::get('/programs/create', [CoordinatorController::class, 'createProgram'])->name('programs.create');
    Route::post('/programs', [CoordinatorController::class, 'storeProgram'])->name('programs.store');
    Route::get('/programs/{id}', [CoordinatorController::class, 'showProgram'])->name('programs.show');
    Route::get('/programs/{id}/edit', [CoordinatorController::class, 'editProgram'])->name('programs.edit');
    Route::put('/programs/{id}', [CoordinatorController::class, 'updateProgram'])->name('programs.update');
    
    // Participants
    Route::get('/programs/{id}/participants', [CoordinatorController::class, 'participants'])->name('participants');
    Route::post('/programs/{programId}/participants/{registrationId}/remove', [CoordinatorController::class, 'removeParticipant'])->name('participants.remove');
    
    // Sessions
    Route::get('/programs/{id}/sessions', [CoordinatorController::class, 'sessions'])->name('sessions');
    Route::get('/programs/{id}/sessions/create', [CoordinatorController::class, 'createSession'])->name('sessions.create');
    Route::post('/programs/{id}/sessions', [CoordinatorController::class, 'storeSession'])->name('sessions.store');
    Route::get('/programs/{programId}/sessions/{sessionId}/edit', [CoordinatorController::class, 'editSession'])->name('sessions.edit');
    Route::put('/programs/{programId}/sessions/{sessionId}', [CoordinatorController::class, 'updateSession'])->name('sessions.update');
    
    // Attendance
    Route::get('/sessions/{id}/attendance', [CoordinatorController::class, 'attendance'])->name('attendance');
    Route::post('/sessions/{id}/attendance', [CoordinatorController::class, 'recordAttendance'])->name('attendance.record');
    
    // Progress
    Route::get('/registrations/{id}/progress', [CoordinatorController::class, 'progress'])->name('progress');
    Route::post('/registrations/{id}/progress', [CoordinatorController::class, 'storeProgress'])->name('progress.store');
    Route::put('/registrations/{registrationId}/progress/{metricId}', [CoordinatorController::class, 'updateProgress'])->name('progress.update');
    
    // Reports
    Route::get('/programs/{id}/reports', [CoordinatorController::class, 'reports'])->name('reports');
    Route::get('/programs/{id}/export-attendance', [CoordinatorController::class, 'exportAttendance'])->name('export-attendance');
    Route::get('/programs/{id}/export-progress', [CoordinatorController::class, 'exportProgress'])->name('export-progress');
    
    // Profile
    Route::get('/profile', [CoordinatorController::class, 'profile'])->name('profile');
    Route::put('/profile', [CoordinatorController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CoordinatorController::class, 'updatePassword'])->name('profile.password');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Programs
    Route::get('/programs', [AdminController::class, 'programs'])->name('programs');
    Route::get('/programs/create', [AdminController::class, 'createProgram'])->name('programs.create');
    Route::post('/programs', [AdminController::class, 'storeProgram'])->name('programs.store');
    Route::get('/programs/{id}', [AdminController::class, 'showProgram'])->name('programs.show');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Audit Logs
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit-logs');
    
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/generate', [AdminController::class, 'generateReport'])->name('reports.generate');
});
