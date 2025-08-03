<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DailyJournal;
use App\Models\PrakerinPlacement;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrakerinController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get statistics for the dashboard
        $stats = [
            'total_students' => Student::count(),
            'total_companies' => Company::active()->count(),
            'active_placements' => PrakerinPlacement::ongoing()->count(),
            'completed_placements' => PrakerinPlacement::completed()->count(),
        ];

        // Get role-specific data
        $dashboardData = [];
        
        if ($user->role === 'student' && $user->student) {
            $currentPlacement = $user->student->currentPlacement()->with(['company', 'supervisingTeacher'])->first();
            $recentJournals = $currentPlacement 
                ? $currentPlacement->dailyJournals()->latest('journal_date')->take(5)->get()
                : collect();
                
            $dashboardData = [
                'current_placement' => $currentPlacement,
                'recent_journals' => $recentJournals,
            ];
        } elseif ($user->role === 'teacher' && $user->teacher) {
            $supervisedPlacements = $user->teacher->supervisedPlacements()
                ->with(['student', 'company'])
                ->where('status', 'ongoing')
                ->get();
                
            $dashboardData = [
                'supervised_placements' => $supervisedPlacements,
            ];
        } elseif ($user->role === 'company_representative' && $user->companyRepresentative) {
            $companyPlacements = PrakerinPlacement::where('company_id', $user->companyRepresentative->company_id)
                ->with(['student'])
                ->where('status', 'ongoing')
                ->get();
                
            $dashboardData = [
                'company_placements' => $companyPlacements,
            ];
        }

        return Inertia::render('prakerin/dashboard', [
            'stats' => $stats,
            'dashboard_data' => $dashboardData,
            'user_role' => $user->role,
        ]);
    }

    /**
     * Display student journal form.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'student' || !$user->student) {
            abort(403, 'Unauthorized');
        }

        $currentPlacement = $user->student->currentPlacement()->with(['company', 'supervisingTeacher'])->first();
        
        if (!$currentPlacement) {
            return redirect()->route('prakerin.index')
                ->with('error', 'You do not have an active Prakerin placement.');
        }

        $today = now()->format('Y-m-d');
        $existingJournal = DailyJournal::where('placement_id', $currentPlacement->id)
            ->where('journal_date', $today)
            ->first();

        return Inertia::render('prakerin/journal-form', [
            'placement' => $currentPlacement,
            'existing_journal' => $existingJournal,
            'journal_date' => $today,
        ]);
    }

    /**
     * Store a daily journal entry.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'student' || !$user->student) {
            abort(403, 'Unauthorized');
        }

        $currentPlacement = $user->student->currentPlacement()->first();
        
        if (!$currentPlacement) {
            return redirect()->route('prakerin.index')
                ->with('error', 'You do not have an active Prakerin placement.');
        }

        $validated = $request->validate([
            'journal_date' => 'required|date',
            'activities' => 'required|string|min:10',
            'learning_outcomes' => 'nullable|string',
            'challenges' => 'nullable|string',
            'attendance_status' => 'required|in:present,absent,sick,permission',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i',
        ]);

        DailyJournal::updateOrCreate(
            [
                'placement_id' => $currentPlacement->id,
                'journal_date' => $validated['journal_date'],
            ],
            $validated
        );

        return Inertia::render('prakerin/journal-form', [
            'placement' => $currentPlacement->load(['company', 'supervisingTeacher']),
            'existing_journal' => DailyJournal::where('placement_id', $currentPlacement->id)
                ->where('journal_date', $validated['journal_date'])
                ->first(),
            'journal_date' => $validated['journal_date'],
            'success' => 'Journal entry saved successfully!',
        ]);
    }
}