<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Student attendance list
     */
    public function index(Request $request)
    {
        $student = auth()->user()->student;

        // 🔐 Safety
        if (! $student) {
            abort(403);
        }

        // Student ke batch_student IDs
        $batchStudentIds = BatchStudent::where('student_id', $student->id)
            ->pluck('id');

        $query = Attendance::with([
                'batch_student.batch',
            ])
            ->whereIn('batch_student_id', $batchStudentIds)
            ->orderByDesc('attendance_date');

        /* ================= FILTERS ================= */

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        // Status filter (present / absent)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->paginate(20);

        return view(
            'student.attendance.index',
            compact('attendances')
        );
    }
}
