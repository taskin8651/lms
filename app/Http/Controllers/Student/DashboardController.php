<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BatchStudent;
use App\Models\Attendance;
use App\Models\LiveClass;
use App\Models\Test;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Student ke batches
        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        // Attendance %
        $totalAttendance = Attendance::whereHas('batch_student', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })->count();

        $presentAttendance = Attendance::where('status', 'present')
            ->whereHas('batch_student', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })->count();

        $attendancePercent = $totalAttendance > 0
            ? round(($presentAttendance / $totalAttendance) * 100)
            : 0;

        // Today live classes
        $todayClasses = LiveClass::whereIn('batch_id', $batchIds)
            ->whereDate('class_date', Carbon::today())
            ->get();

        // Upcoming tests (published only)
        $upcomingTests = Test::whereIn('batch_id', $batchIds)
            ->where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'batchIds',
            'attendancePercent',
            'todayClasses',
            'upcomingTests'
        ));
    }
}
