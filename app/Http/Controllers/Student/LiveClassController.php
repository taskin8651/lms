<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\BatchStudent;
use Carbon\Carbon;

class LiveClassController extends Controller
{
    /**
     * Student → Live Classes (All + Today)
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

        // 🔴 No batch = no classes
        if ($batchIds->isEmpty()) {
            return view(
                'student.live-classes.index',
                [
                    'liveClasses'  => collect(),
                    'todayClasses' => collect(),
                ]
            );
        }

        // All active live classes (batch-wise)
        $liveClasses = LiveClass::with([
                'batch',
                'teacher.user'
            ])
            ->whereIn('batch_id', $batchIds)
            ->where('status', 'active')
            ->orderByDesc('class_date')
            ->orderByDesc('start_time')
            ->get();

        // Today’s live classes
        $todayClasses = $liveClasses->filter(function ($class) {
            return Carbon::parse($class->class_date)
                ->isSameDay(Carbon::today());
        });

        return view(
            'student.live-classes.index',
            compact('liveClasses', 'todayClasses')
        );
    }
}
