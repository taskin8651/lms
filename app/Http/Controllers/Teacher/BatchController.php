<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchStudent;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Show all batches assigned to logged-in teacher
     */
    public function index()
    {
        $teacher = auth()->user()->teacher;

        // Security check (extra safety)
        if (!$teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $batches = Batch::with([
                'class_level',
                'subject',
            ])
            ->withCount('students')          // 🔥 total students in batch
            ->where('teacher_id', $teacher->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('teacher.batches.index', compact('batches'));
    }

    /**
     * Show students of a specific batch
     */
   public function students(Request $request, Batch $batch)
{
    $teacher = auth()->user()->teacher;

    if ($batch->teacher_id !== $teacher->id) {
        abort(403);
    }

    $query = BatchStudent::with(['student.user'])
        ->where('batch_id', $batch->id);

    // 🔍 Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🔍 Search by name / mobile
    if ($request->filled('search')) {
        $query->whereHas('student.user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        })->orWhereHas('student', function ($q) use ($request) {
            $q->where('mobile', 'like', '%' . $request->search . '%');
        });
    }

    $students = $query->orderBy('joining_date')->get();

    return view('teacher.batches.students', compact('batch', 'students'));
}
}
