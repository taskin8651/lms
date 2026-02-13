<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Chapter;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;

class StudyMaterialController extends Controller
{
    /**
     * List Materials (Batch Wise)
     */
    public function index(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if ((int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $materials = StudyMaterial::with('chapter')
            ->where('batch_id', $batch->id)
            ->latest()
            ->get();

        return view(
            'teacher.study-materials.index',
            compact('batch', 'materials')
        );
    }

    /**
     * Create Form
     */
    public function create(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if ((int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $chapters = Chapter::where('subject_id', $batch->subject_id)
            ->orderBy('order_no')
            ->get();

        return view(
            'teacher.study-materials.create',
            compact('batch', 'chapters')
        );
    }

    /**
     * Store Material
     */
    public function store(Request $request, Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if ((int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:255',
            'status' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx',
            'video_link' => 'nullable|url'
        ]);

        $material = StudyMaterial::create([
            'batch_id' => $batch->id,
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'video_link' => $request->video_link,
        ]);

        if ($request->hasFile('file')) {
            $material
                ->addMediaFromRequest('file')
                ->toMediaCollection('file');
        }

        return redirect()
            ->route('teacher.batches.materials', $batch)
            ->with('success', 'Study material added successfully.');
    }

    
}
