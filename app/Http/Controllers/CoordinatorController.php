<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Session;
use App\Models\Attendance;
use App\Models\Registration;
use App\Models\ProgressMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinatorController extends Controller
{
    public function dashboard()
    {
        $coordinator = Auth::user();
        $programs = Program::where('coordinator_id', $coordinator->id)
            ->withCount('registrations')
            ->get();
        
        $upcomingSessions = Session::whereHas('program', function($q) use ($coordinator) {
            $q->where('coordinator_id', $coordinator->id);
        })
        ->where('session_date', '>', now())
        ->orderBy('session_date')
        ->take(5)
        ->get();

        return view('coordinator.dashboard', compact('programs', 'upcomingSessions'));
    }

    public function allSessions()
    {
        $sessions = Session::whereHas('program', function($q) {
            $q->where('coordinator_id', Auth::id());
        })
        ->with(['program'])
        ->orderBy('session_date', 'desc')
        ->paginate(20);

        return view('coordinator.all-sessions', compact('sessions'));
    }

    public function allParticipants()
    {
        $participants = Registration::whereHas('program', function($q) {
            $q->where('coordinator_id', Auth::id());
        })
        ->with(['user', 'program'])
        ->orderBy('registered_at', 'desc')
        ->paginate(20);

        return view('coordinator.all-participants', compact('participants'));
    }

    public function programs()
    {
        $programs = Program::where('coordinator_id', Auth::id())
            ->withCount(['registrations', 'sessions'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('coordinator.programs', compact('programs'));
    }

    public function createProgram()
    {
        return view('coordinator.create-program');
    }

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_deadline' => 'required|date|before:start_date',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:draft,active',
        ]);

        $validated['coordinator_id'] = Auth::id();
        $validated['enrolled_count'] = 0;

        $program = Program::create($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model' => 'Program',
            'model_id' => $program->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('coordinator.programs')->with('success', 'Program created successfully!');
    }

    public function editProgram($id)
    {
        $program = Program::where('id', $id)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        return view('coordinator.edit-program', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $program = Program::where('id', $id)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_deadline' => 'required|date|before:start_date',
            'capacity' => 'required|integer|min:' . $program->enrolled_count,
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        $oldValues = $program->toArray();
        $program->update($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model' => 'Program',
            'model_id' => $id,
            'old_values' => $oldValues,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('coordinator.programs')->with('success', 'Program updated successfully!');
    }

    public function showProgram($id)
    {
        $program = Program::where('id', $id)
            ->where('coordinator_id', Auth::id())
            ->with(['sessions', 'registrations.user'])
            ->firstOrFail();

        return view('coordinator.program-details', compact('program'));
    }

    public function participants($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $registrations = Registration::with('user')
            ->where('program_id', $programId)
            ->orderBy('registered_at', 'desc')
            ->get();

        return view('coordinator.participants', compact('program', 'registrations'));
    }

    public function removeParticipant(Request $request, $programId, $registrationId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $registration = Registration::where('id', $registrationId)
            ->where('program_id', $programId)
            ->firstOrFail();

        $validated = $request->validate([
            'withdrawal_reason' => 'required|string',
        ]);

        $oldValues = $registration->toArray();
        
        $registration->update([
            'status' => 'withdrawn',
            'withdrawal_reason' => $validated['withdrawal_reason'],
        ]);

        $program->decrement('enrolled_count');

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model' => 'Registration',
            'model_id' => $registrationId,
            'old_values' => $oldValues,
            'new_values' => $registration->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Participant removed successfully!');
    }

    public function sessions($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->withCount('registrations')
            ->firstOrFail();

        $sessions = Session::where('program_id', $programId)
            ->orderBy('session_date')
            ->get();

        return view('coordinator.sessions', compact('program', 'sessions'));
    }

    public function createSession($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        return view('coordinator.create-session', compact('program'));
    }

    public function storeSession(Request $request, $programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilitator' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'session_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $validated['program_id'] = $programId;
        $validated['status'] = 'scheduled';

        $session = Session::create($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model' => 'Session',
            'model_id' => $session->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('coordinator.sessions', $programId)->with('success', 'Session created successfully!');
    }

    public function editSession($programId, $sessionId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $session = Session::where('id', $sessionId)
            ->where('program_id', $programId)
            ->firstOrFail();

        return view('coordinator.edit-session', compact('program', 'session'));
    }

    public function updateSession(Request $request, $programId, $sessionId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->firstOrFail();

        $session = Session::where('id', $sessionId)
            ->where('program_id', $programId)
            ->firstOrFail();

        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilitator' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'session_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        $oldValues = $session->toArray();
        $session->update($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model' => 'Session',
            'model_id' => $sessionId,
            'old_values' => $oldValues,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('coordinator.sessions', $programId)->with('success', 'Session updated successfully!');
    }

    public function attendance($sessionId)
    {
        $session = Session::with(['program', 'attendance.user'])
            ->whereHas('program', function($q) {
                $q->where('coordinator_id', Auth::id());
            })
            ->findOrFail($sessionId);

        $participants = Registration::with('user')
            ->where('program_id', $session->program_id)
            ->whereIn('status', ['registered', 'active'])
            ->get();

        return view('coordinator.attendance', compact('session', 'participants'));
    }

    public function recordAttendance(Request $request, $sessionId)
    {
        $session = Session::whereHas('program', function($q) {
            $q->where('coordinator_id', Auth::id());
        })->findOrFail($sessionId);

        $validated = $request->validate([
            'attendance' => 'required|array',
            'attendance.*.user_id' => 'required|exists:users,id',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.notes' => 'nullable|string',
        ]);

        foreach ($validated['attendance'] as $record) {
            Attendance::updateOrCreate(
                [
                    'session_id' => $sessionId,
                    'user_id' => $record['user_id'],
                ],
                [
                    'status' => $record['status'],
                    'notes' => $record['notes'] ?? null,
                    'recorded_by' => Auth::id(),
                    'checked_in_at' => $record['status'] === 'present' ? now() : null,
                ]
            );
        }

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model' => 'Attendance',
            'model_id' => $sessionId,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Attendance recorded successfully!');
    }

    public function progress($registrationId)
    {
        $registration = Registration::with(['user', 'program', 'progressMetrics.recorder'])
            ->whereHas('program', function($q) {
                $q->where('coordinator_id', Auth::id());
            })
            ->findOrFail($registrationId);

        return view('coordinator.progress', compact('registration'));
    }

    public function storeProgress(Request $request, $registrationId)
    {
        $registration = Registration::whereHas('program', function($q) {
            $q->where('coordinator_id', Auth::id());
        })->findOrFail($registrationId);

        $validated = $request->validate([
            'metric_type' => 'required|string|max:100',
            'metric_value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:50',
            'recorded_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['registration_id'] = $registrationId;
        $validated['recorded_by'] = Auth::id();

        $metric = ProgressMetric::create($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model' => 'ProgressMetric',
            'model_id' => $metric->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Progress metric recorded successfully!');
    }

    public function updateProgress(Request $request, $registrationId, $metricId)
    {
        $registration = Registration::whereHas('program', function($q) {
            $q->where('coordinator_id', Auth::id());
        })->findOrFail($registrationId);

        $metric = ProgressMetric::where('id', $metricId)
            ->where('registration_id', $registrationId)
            ->firstOrFail();

        $validated = $request->validate([
            'metric_type' => 'required|string|max:100',
            'metric_value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:50',
            'recorded_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $oldValues = $metric->toArray();
        $metric->update($validated);

        // Log audit
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model' => 'ProgressMetric',
            'model_id' => $metricId,
            'old_values' => $oldValues,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Progress metric updated successfully!');
    }

    public function reports($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->with(['registrations.user', 'sessions.attendance'])
            ->firstOrFail();

        return view('coordinator.reports', compact('program'));
    }

    public function exportAttendance($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->with(['sessions.attendance.user'])
            ->firstOrFail();

        $filename = "attendance_report_{$program->name}_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($program) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Session Date', 'Session Topic', 'Participant Name', 'Status', 'Check-in Time']);

            foreach ($program->sessions as $session) {
                foreach ($session->attendance as $attendance) {
                    fputcsv($file, [
                        $session->session_date->format('Y-m-d H:i'),
                        $session->topic,
                        $attendance->user->name,
                        $attendance->status,
                        $attendance->checked_in_at ? $attendance->checked_in_at->format('Y-m-d H:i') : 'N/A',
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProgress($programId)
    {
        $program = Program::where('id', $programId)
            ->where('coordinator_id', Auth::id())
            ->with(['registrations.user', 'registrations.progressMetrics'])
            ->firstOrFail();

        $filename = "progress_report_{$program->name}_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($program) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Participant Name', 'Metric Type', 'Value', 'Unit', 'Recorded Date', 'Notes']);

            foreach ($program->registrations as $registration) {
                foreach ($registration->progressMetrics as $metric) {
                    fputcsv($file, [
                        $registration->user->name,
                        $metric->metric_type,
                        $metric->metric_value,
                        $metric->unit ?? 'N/A',
                        $metric->recorded_date->format('Y-m-d'),
                        $metric->notes ?? 'N/A',
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function profile()
    {
        return view('coordinator.profile');
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
    }
}
