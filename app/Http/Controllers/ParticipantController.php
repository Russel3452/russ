<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Registration;
use App\Models\Attendance;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $registrations = Registration::with('program')
            ->where('user_id', $user->id)
            ->whereIn('status', ['registered', 'active'])
            ->get();
        
        $upcomingSessions = Session::whereHas('program.registrations', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('session_date', '>', now())
        ->orderBy('session_date')
        ->take(5)
        ->get();

        return view('participant.dashboard', compact('registrations', 'upcomingSessions'));
    }

    public function programs()
    {
        $userId = Auth::id();
        
        $programs = Program::where('status', 'active')
            ->where('enrollment_deadline', '>=', now())
            ->with(['coordinator', 'registrations' => function($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->paginate(9);

        return view('participant.programs', compact('programs'));
    }

    public function showProgram($id)
    {
        $program = Program::with(['coordinator', 'sessions'])->findOrFail($id);
        
        $registration = Registration::where('user_id', Auth::id())
            ->where('program_id', $id)
            ->first();
            
        // User is registered only if they have an active registration (not withdrawn)
        $isRegistered = $registration && $registration->status !== 'withdrawn';
        $isWithdrawn = $registration && $registration->status === 'withdrawn';

        return view('participant.program-details', compact('program', 'isRegistered', 'isWithdrawn'));
    }

    public function register(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        $user = Auth::user();

        // Check enrollment deadline
        if ($program->enrollment_deadline < now()->toDateString()) {
            return back()->with('error', 'Enrollment deadline has passed.');
        }

        // Check capacity
        if ($program->isFull()) {
            return back()->with('error', 'This program is full.');
        }

        // Check if already registered (excluding withdrawn status)
        $existingRegistration = Registration::where('user_id', $user->id)
            ->where('program_id', $id)
            ->first();
            
        if ($existingRegistration && $existingRegistration->status !== 'withdrawn') {
            return back()->with('error', 'You are already registered for this program.');
        }

        // Check max active programs limit
        $maxPrograms = \App\Models\SystemSetting::get('max_active_programs', 3);
        $activeCount = Registration::where('user_id', $user->id)
            ->whereIn('status', ['registered', 'active'])
            ->count();

        if ($activeCount >= $maxPrograms) {
            return back()->with('error', "You can only register for up to {$maxPrograms} programs at a time.");
        }

        $validated = $request->validate([
            'health_goals' => 'nullable|string',
            'personal_notes' => 'nullable|string',
        ]);

        // If user has withdrawn registration, update it, otherwise create new
        if ($existingRegistration && $existingRegistration->status === 'withdrawn') {
            $existingRegistration->update([
                'health_goals' => $validated['health_goals'] ?? null,
                'personal_notes' => $validated['personal_notes'] ?? null,
                'status' => 'registered',
                'registered_at' => now(),
            ]);
        } else {
            Registration::create([
                'user_id' => $user->id,
                'program_id' => $id,
                'health_goals' => $validated['health_goals'] ?? null,
                'personal_notes' => $validated['personal_notes'] ?? null,
                'status' => 'registered',
                'registered_at' => now(),
            ]);
        }

        // Increment enrolled count
        $program->increment('enrolled_count');

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'create',
            'model' => 'Registration',
            'model_id' => $id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('participant.my-programs')->with('success', 'Successfully registered for the program!');
    }

    public function myPrograms()
    {
        $user = Auth::user();
        $registrations = Registration::with(['program.coordinator', 'program.sessions'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('participant.my-programs', compact('registrations'));
    }

    public function attendance()
    {
        $user = Auth::user();
        $attendance = Attendance::with(['session.program'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('participant.attendance', compact('attendance'));
    }

    public function checkIn($sessionId)
    {
        $user = Auth::user();
        $session = Session::findOrFail($sessionId);

        // Check if registered for the program
        $isRegistered = Registration::where('user_id', $user->id)
            ->where('program_id', $session->program_id)
            ->whereIn('status', ['registered', 'active'])
            ->exists();

        if (!$isRegistered) {
            return back()->with('error', 'You are not registered for this program.');
        }

        // Check if session is today
        if (!$session->isToday()) {
            return back()->with('error', 'You can only check in on the day of the session.');
        }

        // Check if already checked in
        $existing = Attendance::where('session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already checked in for this session.');
        }

        Attendance::create([
            'session_id' => $sessionId,
            'user_id' => $user->id,
            'status' => 'present',
            'checked_in_at' => now(),
            'recorded_by' => $user->id,
        ]);

        return back()->with('success', 'Successfully checked in!');
    }

    public function progress($registrationId)
    {
        $registration = Registration::with(['program', 'progressMetrics.recorder'])
            ->where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('participant.progress', compact('registration'));
    }

    public function updateGoals(Request $request, $registrationId)
    {
        $registration = Registration::where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'health_goals' => 'required|string',
            'personal_notes' => 'nullable|string',
        ]);

        $oldValues = [
            'health_goals' => $registration->health_goals,
            'personal_notes' => $registration->personal_notes,
        ];

        $registration->update($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model' => 'Registration',
            'model_id' => $registrationId,
            'old_values' => $oldValues,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Goals updated successfully!');
    }

    public function profile()
    {
        return view('participant.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user->update($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'User',
            'model_id' => $user->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check if current password is correct
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => \Hash::make($request->password),
        ]);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'User',
            'model_id' => $user->id,
            'new_values' => ['password' => 'changed'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Password updated successfully!');

        return back()->with('success', 'Goals updated successfully!');
    }
}
