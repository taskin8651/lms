<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Batch;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;

        /* =========================
         | Attendance List
         ========================= */
        $attendanceQuery = Attendance::with([
                'batch_student.batch',
                'batch_student.student.user'
            ])
            ->whereHas('batch_student.batch', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            });

        // 🔹 Date filter
        if ($request->filled('date')) {
            $attendanceQuery->whereDate('attendance_date', $request->date);
        }

        // 🔹 Status filter
        if ($request->filled('status')) {
            $attendanceQuery->where('status', $request->status);
        }

        // 🔹 Student name filter
        if ($request->filled('student')) {
            $attendanceQuery->whereHas(
                'batch_student.student.user',
                function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->student . '%');
                }
            );
        }

        $attendances = $attendanceQuery
            ->orderBy('attendance_date', 'desc')
            ->paginate(20);

        /* =========================
         | Batch-wise Summary
         ========================= */
        $batchSummary = Attendance::selectRaw('
                batch_students.batch_id,
                batches.name as batch_name,
                SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as absent_count
            ')
            ->join('batch_students', 'batch_students.id', '=', 'attendances.batch_student_id')
            ->join('batches', 'batches.id', '=', 'batch_students.batch_id')
            ->where('batches.teacher_id', $teacher->id)
            ->when($request->filled('date'), function ($q) use ($request) {
                $q->whereDate('attendances.attendance_date', $request->date);
            })
            ->groupBy('batch_students.batch_id', 'batches.name')
            ->get();

           

        return view(
            'teacher.attendance.index',
            compact('attendances', 'batchSummary')
        );
    }

    public function todayBatch(Batch $batch)
{
    $teacher = auth()->user()->teacher;

    // 🔒 Security
    if ($batch->teacher_id !== $teacher->id) {
        abort(403);
    }

    $today = Carbon::today()->format('Y-m-d');

    // 🔹 Today attendance list (student-wise)
    $attendances = Attendance::with([
            'batch_student.student.user'
        ])
        ->whereDate('attendance_date', $today)
        ->whereHas('batch_student', function ($q) use ($batch) {
            $q->where('batch_id', $batch->id);
        })
        ->get();

    // 🔹 Today summary
    $summary = [
        'present' => $attendances->where('status', 'present')->count(),
        'absent'  => $attendances->where('status', 'absent')->count(),
    ];

    return view(
        'teacher.attendance.batch-today',
        compact('batch', 'attendances', 'summary')
    );
}


public function studentHistory(Batch $batch, Student $student)
{
    $teacher = auth()->user()->teacher;

    // 🔒 Security: teacher apna batch hi dekhe
    if ($batch->teacher_id !== $teacher->id) {
        abort(403);
    }

    $attendances = Attendance::whereHas('batch_student', function ($q) use ($batch, $student) {
            $q->where('batch_id', $batch->id)
              ->where('student_id', $student->id);
        })
        ->orderBy('attendance_date', 'desc')
        ->get();

    return view(
        'teacher.attendance.student-history',
        compact('batch', 'student', 'attendances')
    );
}
}
