<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Batch;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /* =========================
     | Attendance Dashboard
     ========================= */
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher) {
            abort(403);
        }

        /* ================= Attendance List ================= */
        $attendanceQuery = Attendance::with([
                'batch_student.batch',
                'batch_student.student.user'
            ])
            ->whereHas('batch_student.batch', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            });

        if ($request->filled('date')) {
            $attendanceQuery->whereDate('attendance_date', $request->date);
        }

        if ($request->filled('status')) {
            $attendanceQuery->where('status', $request->status);
        }

        if ($request->filled('student')) {
            $attendanceQuery->whereHas(
                'batch_student.student.user',
                fn ($q) =>
                    $q->where('name', 'like', '%' . $request->student . '%')
            );
        }

        $attendances = $attendanceQuery
            ->orderByDesc('attendance_date')
            ->paginate(20);

        /* ================= Batch Summary ================= */
        $batchSummary = Attendance::selectRaw('
                batch_students.batch_id,
                batches.name as batch_name,
                SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as absent_count
            ')
            ->join('batch_students', 'batch_students.id', '=', 'attendances.batch_student_id')
            ->join('batches', 'batches.id', '=', 'batch_students.batch_id')
            ->where('batches.teacher_id', $teacher->id)
            ->when($request->filled('date'), fn ($q) =>
                $q->whereDate('attendances.attendance_date', $request->date)
            )
            ->groupBy('batch_students.batch_id', 'batches.name')
            ->get();

        return view(
            'teacher.attendance.index',
            compact('attendances', 'batchSummary')
        );
    }

    /* =========================
     | Today Batch Attendance
     ========================= */
    public function todayBatch(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $today = Carbon::today();

        $attendances = Attendance::with('batch_student.student.user')
            ->whereDate('attendance_date', $today)
            ->whereHas('batch_student', fn ($q) =>
                $q->where('batch_id', $batch->id)
            )
            ->get();

        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent'  => $attendances->where('status', 'absent')->count(),
        ];

        return view(
            'teacher.attendance.batch-today',
            compact('batch', 'attendances', 'summary')
        );
    }

    /* =========================
     | Student Attendance History
     ========================= */
    public function studentHistory(Batch $batch, Student $student)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $attendances = Attendance::whereHas('batch_student', fn ($q) =>
                $q->where('batch_id', $batch->id)
                  ->where('student_id', $student->id)
            )
            ->orderByDesc('attendance_date')
            ->get();

        return view(
            'teacher.attendance.student-history',
            compact('batch', 'student', 'attendances')
        );
    }
}
