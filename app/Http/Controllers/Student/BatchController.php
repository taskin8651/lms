<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchStudent;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Student → My Batches
     */
    public function index()
    {
        $student = auth()->user()->student;

        // 🔐 Safety
        if (! $student) {
            abort(403);
        }

        // Student ke enrolled batch IDs
        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        $batches = Batch::with([
                'teacher.user',
                'subject',
                'class_level',
            ])
            ->whereIn('id', $batchIds)
            ->where('status', 'active')
            ->orderByDesc('id')
            ->get();

        return view(
            'student.batches.index',
            compact('batches')
        );
    }

    /**
     * Single Batch Dashboard (Student View)
     */
    public function show(Batch $batch)
    {
        $student = auth()->user()->student;

        // 🔐 Safety
        if (! $student) {
            abort(403);
        }

        // 🔒 Ensure student is enrolled in this batch
        $isEnrolled = BatchStudent::where([
                'student_id' => $student->id,
                'batch_id'   => $batch->id,
            ])->exists();

        if (! $isEnrolled) {
            abort(403);
        }

        /**
         * 🔮 Future Ready (jab chaaho enable kar sakte ho)
         *
         * $attendanceCount = ...
         * $testCount = ...
         * $liveClasses = ...
         */

        return view(
            'student.batches.show',
            compact('batch')
        );
    }
}
