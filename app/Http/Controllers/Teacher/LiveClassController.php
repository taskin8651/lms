<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\LiveClass;
use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    /* ================= LIVE CLASS LIST ================= */
    public function index(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $liveClasses = LiveClass::where('batch_id', $batch->id)
            ->orderByDesc('class_date')
            ->get();

        return view('teacher.live-classes.index', compact('batch', 'liveClasses'));
    }

    /* ================= CREATE FORM ================= */
    public function create(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        return view('teacher.live-classes.create', compact('batch'));
    }

    /* ================= STORE ================= */
    public function store(Request $request, Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $request->validate([
            'class_date'   => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'class_type'   => 'required',
            'topic'        => 'required|string|max:255',
            'meeting_link' => 'nullable|url',
        ]);

        LiveClass::create([
            'batch_id'       => $batch->id,
            'teacher_id'     => $teacher->id,
            'class_date'     => $request->class_date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'class_type'     => $request->class_type,
            'topic'          => $request->topic,
            'description'    => $request->description,
            'meeting_link'   => $request->meeting_link,
            'recording_link' => $request->recording_link,
            'status'         => 'active',
        ]);

        return redirect()
            ->route('teacher.batches.live-classes', $batch->id)
            ->with('success', 'Live class scheduled successfully.');
    }
}
