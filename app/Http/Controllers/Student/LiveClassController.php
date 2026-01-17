<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\BatchStudent;
use Carbon\Carbon;

class LiveClassController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Student ke batches
        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        // Live classes (batch wise)
        $liveClasses = LiveClass::with('batch')
            ->whereIn('batch_id', $batchIds)
            ->where('status', 'active')
            ->orderBy('class_date', 'desc')
            ->get();

        // Today classes
        $todayClasses = $liveClasses->where(
            'class_date',
            Carbon::today()->format(config('panel.date_format'))
        );

        return view(
            'student.live-classes.index',
            compact('liveClasses', 'todayClasses')
        );
    }
}
