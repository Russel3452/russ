<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Registration;
use App\Models\SystemSetting;
use App\Models\AuditLog;
use App\Models\GeneratedReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_programs' => Program::count(),
            'active_programs' => Program::where('status', 'active')->count(),
            'total_registrations' => Registration::count(),
        ];

        $recentActivities = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Chart data - User registrations per month (last 6 months)
        $userChartData = [];
        $userChartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $userChartLabels[] = $date->format('M Y');
            $userChartData[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Chart data - Program registrations per month (last 6 months)
        $programChartData = [];
        $programChartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $programChartLabels[] = $date->format('M Y');
            $programChartData[] = Program::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Chart data - Registrations trend (last 6 months)
        $registrationChartData = [];
        $registrationChartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $registrationChartLabels[] = $date->format('M Y');
            $registrationChartData[] = Registration::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentActivities',
            'userChartData',
            'userChartLabels',
            'programChartData',
            'programChartLabels',
            'registrationChartData',
            'registrationChartLabels'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $coordinatorCount = User::where('role', 'coordinator')->count();
        $participantCount = User::where('role', 'participant')->count();

        return view('admin.users', compact('users', 'totalUsers', 'adminCount', 'coordinatorCount', 'participantCount'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:participant,coordinator,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Log audit
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'User',
            'model_id' => $user->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:participant,coordinator,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $oldValues = $user->toArray();
        $user->update($validated);

        // Log audit
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'User',
            'model_id' => $id,
            'old_values' => $oldValues,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $oldValues = $user->toArray();
        $user->delete();

        // Log audit
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'User',
            'model_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function destroyUser($id)
    {
        return $this->deleteUser($id);
    }

    public function programs(Request $request)
    {
        $query = Program::with('coordinator')
            ->withCount('registrations');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics for all programs (not just filtered)
        $totalPrograms = Program::count();
        $activePrograms = Program::where('status', 'active')->count();
        $totalParticipants = Registration::count();
        $totalCoordinators = Program::distinct('coordinator_id')->count('coordinator_id');

        return view('admin.programs', compact('programs', 'totalPrograms', 'activePrograms', 'totalParticipants', 'totalCoordinators'));
    }

    public function showProgram($id)
    {
        $program = Program::with(['coordinator', 'registrations.user', 'sessions'])
            ->withCount('registrations')
            ->findOrFail($id);

        return view('admin.show-program', compact('program'));
    }

    public function createProgram()
    {
        $coordinators = User::where('role', 'coordinator')->get();
        return view('admin.create-program', compact('coordinators'));
    }

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:fitness,nutrition,mental health,wellness',
            'coordinator_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'enrollment_deadline' => 'required|date|before_or_equal:start_date',
            'duration' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $program = Program::create($validated);

        // Log audit
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Program',
            'model_id' => $program->id,
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.programs')->with('success', 'Program created successfully!');
    }

    public function settings()
    {
        $settings = SystemSetting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'max_active_programs' => 'required|integer|min:1',
            'wellness_categories' => 'required|string',
            'metric_templates' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value);
        }

        // Log audit
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'SystemSetting',
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Settings updated successfully!');
    }

    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $totalLogs = AuditLog::count();
        $createCount = AuditLog::where('action', 'create')->count();
        $updateCount = AuditLog::where('action', 'update')->count();
        $deleteCount = AuditLog::where('action', 'delete')->count();

        return view('admin.audit-logs', compact('auditLogs', 'totalLogs', 'createCount', 'updateCount', 'deleteCount'));
    }

    public function profile()
    {
        return view('admin.profile');
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
        AuditLog::create([
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
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'User',
            'model_id' => $user->id,
            'new_values' => ['password' => 'changed'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function reports()
    {
        // User statistics
        $userStats = [
            'total' => User::count(),
            'thisMonth' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // Program statistics
        $totalPrograms = Program::count();
        $completedPrograms = Program::where('status', 'completed')->count();
        $programStats = [
            'completed' => $completedPrograms,
            'completionRate' => $totalPrograms > 0 ? round(($completedPrograms / $totalPrograms) * 100) : 0,
        ];

        // Get recent generated reports
        $recentReports = GeneratedReport::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports', compact('userStats', 'programStats', 'recentReports'));
    }

    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:user,program,activity',
            'date_range' => 'required|string',
            'format' => 'required|in:pdf,excel,csv',
        ]);

        // Log the report generation
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'generate_report',
            'model' => 'Report',
            'new_values' => $validated,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Get date range
        $dateRange = $this->getDateRange($request->date_range);

        // Generate report based on type
        switch ($request->report_type) {
            case 'user':
                return $this->generateUserReport($request, $dateRange);
            case 'program':
                return $this->generateProgramReport($request, $dateRange);
            case 'activity':
                return $this->generateActivityReport($request, $dateRange);
        }
    }

    private function getDateRange($range)
    {
        $now = now();
        switch ($range) {
            case 'last_7_days':
                return ['start' => $now->copy()->subDays(7), 'end' => $now];
            case 'last_30_days':
                return ['start' => $now->copy()->subDays(30), 'end' => $now];
            case 'last_3_months':
                return ['start' => $now->copy()->subMonths(3), 'end' => $now];
            case 'last_year':
                return ['start' => $now->copy()->subYear(), 'end' => $now];
            case 'all_time':
            default:
                return null;
        }
    }

    private function generateUserReport(Request $request, $dateRange)
    {
        $query = User::query();

        // Apply date range filter
        if ($dateRange) {
            $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        // Apply role filter
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();
        $format = $request->format;

        // Create filename
        $filename = 'user_report_' . now()->format('Y-m-d_His') . '.' . $format;

        // Save report to database
        GeneratedReport::create([
            'user_id' => auth()->id(),
            'report_type' => 'User Report',
            'date_range' => $request->date_range,
            'format' => strtoupper($format),
            'filters' => [
                'role' => $request->filled('role') ? $request->role : 'all'
            ],
            'filename' => $filename,
        ]);

        // Generate based on format
        switch ($format) {
            case 'csv':
                return $this->generateUserCSV($users, $filename);
            case 'excel':
                return $this->generateUserExcel($users, $filename);
            case 'pdf':
                return $this->generateUserPDF($users, $filename);
            default:
                return $this->generateUserCSV($users, $filename);
        }
    }

    private function generateUserCSV($users, $filename)
    {
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Phone', 'Status', 'Created At']);
            
            // Add data rows
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    ucfirst($user->role),
                    $user->phone ?? 'N/A',
                    ucfirst($user->status ?? 'active'),
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateUserExcel($users, $filename)
    {
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($users) {
            echo "<table border='1'>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Status</th><th>Created At</th>";
            echo "</tr></thead><tbody>";
            
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user->id . "</td>";
                echo "<td>" . htmlspecialchars($user->name) . "</td>";
                echo "<td>" . htmlspecialchars($user->email) . "</td>";
                echo "<td>" . ucfirst($user->role) . "</td>";
                echo "<td>" . htmlspecialchars($user->phone ?? 'N/A') . "</td>";
                echo "<td>" . ucfirst($user->status ?? 'active') . "</td>";
                echo "<td>" . $user->created_at->format('Y-m-d H:i:s') . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateUserPDF($users, $filename)
    {
        
        $data = [
            'users' => $users,
            'generatedDate' => now()->format('F d, Y H:i:s'),
        ];

        $pdf = Pdf::loadView('reports.user-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }

    private function generateProgramReport(Request $request, $dateRange)
    {
        $query = Program::with('coordinator')->withCount('registrations');

        // Apply date range filter
        if ($dateRange) {
            $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $programs = $query->orderBy('created_at', 'desc')->get();
        $format = $request->format;

        // Create filename
        $filename = 'program_report_' . now()->format('Y-m-d_His') . '.' . $format;

        // Save report to database
        GeneratedReport::create([
            'user_id' => auth()->id(),
            'report_type' => 'Program Report',
            'date_range' => $request->date_range,
            'format' => strtoupper($format),
            'filters' => [
                'status' => $request->filled('status') ? $request->status : 'all',
                'category' => $request->filled('category') ? $request->category : 'all'
            ],
            'filename' => $filename,
        ]);

        // Generate based on format
        switch ($format) {
            case 'csv':
                return $this->generateProgramCSV($programs, $filename);
            case 'excel':
                return $this->generateProgramExcel($programs, $filename);
            case 'pdf':
                return $this->generateProgramPDF($programs, $filename);
            default:
                return $this->generateProgramCSV($programs, $filename);
        }
    }

    private function generateProgramCSV($programs, $filename)
    {
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($programs) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Category', 'Coordinator', 'Status', 'Participants', 'Capacity', 'Start Date', 'End Date', 'Location', 'Created At']);
            
            // Add data rows
            foreach ($programs as $program) {
                fputcsv($file, [
                    $program->id,
                    $program->name,
                    ucfirst($program->category),
                    $program->coordinator ? $program->coordinator->name : 'N/A',
                    ucfirst($program->status),
                    $program->registrations_count,
                    $program->capacity ?? 'N/A',
                    $program->start_date ?? 'N/A',
                    $program->end_date ?? 'N/A',
                    $program->location ?? 'N/A',
                    $program->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateProgramExcel($programs, $filename)
    {
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($programs) {
            echo "<table border='1'>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>Name</th><th>Category</th><th>Coordinator</th><th>Status</th><th>Participants</th><th>Capacity</th><th>Start Date</th><th>End Date</th><th>Location</th><th>Created At</th>";
            echo "</tr></thead><tbody>";
            
            foreach ($programs as $program) {
                echo "<tr>";
                echo "<td>" . $program->id . "</td>";
                echo "<td>" . htmlspecialchars($program->name) . "</td>";
                echo "<td>" . ucfirst($program->category) . "</td>";
                echo "<td>" . htmlspecialchars($program->coordinator ? $program->coordinator->name : 'N/A') . "</td>";
                echo "<td>" . ucfirst($program->status) . "</td>";
                echo "<td>" . $program->registrations_count . "</td>";
                echo "<td>" . ($program->capacity ?? 'N/A') . "</td>";
                echo "<td>" . ($program->start_date ?? 'N/A') . "</td>";
                echo "<td>" . ($program->end_date ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($program->location ?? 'N/A') . "</td>";
                echo "<td>" . $program->created_at->format('Y-m-d H:i:s') . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateProgramPDF($programs, $filename)
    {
        
        $data = [
            'programs' => $programs,
            'generatedDate' => now()->format('F d, Y H:i:s'),
        ];

        $pdf = Pdf::loadView('reports.program-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }

    private function generateActivityReport(Request $request, $dateRange)
    {
        $query = AuditLog::with('user');

        // Apply date range filter
        if ($dateRange) {
            $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        // Apply action filter
        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        // Apply model filter
        if ($request->filled('model') && $request->model !== 'all') {
            $query->where('model', $request->model);
        }

        $activities = $query->orderBy('created_at', 'desc')->get();
        $format = $request->format;

        // Create filename
        $filename = 'activity_report_' . now()->format('Y-m-d_His') . '.' . $format;

        // Save report to database
        GeneratedReport::create([
            'user_id' => auth()->id(),
            'report_type' => 'Activity Report',
            'date_range' => $request->date_range,
            'format' => strtoupper($format),
            'filters' => [
                'action' => $request->filled('action') ? $request->action : 'all',
                'model' => $request->filled('model') ? $request->model : 'all'
            ],
            'filename' => $filename,
        ]);

        // Generate based on format
        switch ($format) {
            case 'csv':
                return $this->generateActivityCSV($activities, $filename);
            case 'excel':
                return $this->generateActivityExcel($activities, $filename);
            case 'pdf':
                return $this->generateActivityPDF($activities, $filename);
            default:
                return $this->generateActivityCSV($activities, $filename);
        }
    }

    private function generateActivityCSV($activities, $filename)
    {
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add CSV headers
            fputcsv($file, ['ID', 'User', 'Action', 'Model', 'Model ID', 'IP Address', 'Timestamp']);
            
            // Add data rows
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->user ? $activity->user->name : 'System',
                    ucfirst($activity->action),
                    $activity->model,
                    $activity->model_id ?? 'N/A',
                    $activity->ip_address ?? 'N/A',
                    $activity->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateActivityExcel($activities, $filename)
    {
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($activities) {
            echo "<table border='1'>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>User</th><th>Action</th><th>Model</th><th>Model ID</th><th>IP Address</th><th>Timestamp</th>";
            echo "</tr></thead><tbody>";
            
            foreach ($activities as $activity) {
                echo "<tr>";
                echo "<td>" . $activity->id . "</td>";
                echo "<td>" . htmlspecialchars($activity->user ? $activity->user->name : 'System') . "</td>";
                echo "<td>" . ucfirst($activity->action) . "</td>";
                echo "<td>" . htmlspecialchars($activity->model) . "</td>";
                echo "<td>" . ($activity->model_id ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($activity->ip_address ?? 'N/A') . "</td>";
                echo "<td>" . $activity->created_at->format('Y-m-d H:i:s') . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateActivityPDF($activities, $filename)
    {
        
        $data = [
            'activities' => $activities,
            'generatedDate' => now()->format('F d, Y H:i:s'),
        ];

        $pdf = Pdf::loadView('reports.activity-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }

}