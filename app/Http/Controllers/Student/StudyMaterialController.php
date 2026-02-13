<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\StudyMaterial;
use App\Models\StudyProgress;


class StudyMaterialController extends Controller
{
    /**
     * Show study materials batch-wise
     */
    public function index(Batch $batch)
    {
        $student = auth()->user()->student;

        // 🔒 Security: student enrolled hai ya nahi
        $isEnrolled = BatchStudent::where([
            'student_id' => $student->id,
            'batch_id'   => $batch->id,
        ])->exists();

        if (!$isEnrolled) {
            abort(403);
        }

        // Only active materials
        $materials = StudyMaterial::with('chapter')
            ->where('batch_id', $batch->id)
            ->where('status', 'active')
            ->orderBy('chapter_id')
            ->latest()
            ->get()
            ->groupBy('chapter.name');

        return view(
            'student.study-materials.index',
            compact('batch', 'materials')
        );
    }

     /**
     * Mark material complete
     */
    public function markComplete(StudyMaterial $material)
    {
        $student = auth()->user()->student;

        StudyProgress::updateOrCreate(
            [
                'study_material_id' => $material->id,
                'student_id'        => $student->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        return back()->with('success', 'Marked as completed.');
    }

    public function secureView($id)
{
    $material = StudyMaterial::findOrFail($id);

    $file = $material->getMedia('file')->first();

    return response()->file(
        $file->getPath(),
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$file->file_name.'"'
        ]
    );
}

}
