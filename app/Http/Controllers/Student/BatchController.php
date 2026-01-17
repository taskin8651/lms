<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchStudent;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Student Dashboard → My Batches
     */
    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        // Student ke enrolled batch IDs
        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        // Active batches with relations
        $batches = Batch::with([
                'teacher.user',
                'subject',
                'class_level'
            ])
            ->whereIn('id', $batchIds)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('student.batches.index', compact('batches'));
    }

    /**
     * Single Batch Dashboard (Student View)
     */
    public function show(Batch $batch)
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        // 🔒 Security: student enrolled hai ya nahi
        $isEnrolled = BatchStudent::where('student_id', $student->id)
            ->where('batch_id', $batch->id)
            ->exists();

        if (!$isEnrolled) {
            abort(403, 'You are not enrolled in this batch');
        }

        // (Future use ke liye ready)
        // $attendanceCount = ...
        // $testsCount = ...
        // $liveClasses = ...

        return view('student.batches.show', compact('batch'));
    }
}
