<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\LiveClass;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(403);
        }

        $batches = Batch::where('teacher_id', $teacher->id)->get();
        $batchIds = $batches->pluck('id');

        $totalStudents = BatchStudent::whereIn('batch_id', $batchIds)->count();

        $todayClasses = LiveClass::where('teacher_id', $teacher->id)
            ->whereDate('class_date', Carbon::today())
            ->get();

        $todayAttendance = Attendance::whereDate('attendance_date', Carbon::today())
            ->whereHas('batch_student.batch', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->count();

        return view('teacher.dashboard', compact(
            'batches',
            'totalStudents',
            'todayClasses',
            'todayAttendance'
        ));
    }
}
