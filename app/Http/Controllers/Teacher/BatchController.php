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

        // 🔐 Safety
        if (! $teacher) {
            abort(403);
        }

        $batches = Batch::with([
                'class_level',
                'subject',
            ])
            ->withCount('students') // total students
            ->where('teacher_id', $teacher->id)
            ->orderByDesc('id')
            ->get();

        return view('teacher.batches.index', compact('batches'));
    }

    /**
     * Show students of a specific batch
     */
    public function students(Request $request, Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        // 🔐 Security (SERVER SAFE)
        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $query = BatchStudent::with('student.user')
            ->where('batch_id', $batch->id);

        /* ================= FILTERS ================= */

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name / mobile
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('student.user', function ($u) use ($request) {
                        $u->where('name', 'like', '%' . $request->search . '%');
                    })
                  ->orWhereHas('student', function ($s) use ($request) {
                        $s->where('mobile', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $students = $query
            ->orderBy('joining_date')
            ->get();

        return view(
            'teacher.batches.students',
            compact('batch', 'students')
        );
    }
}
