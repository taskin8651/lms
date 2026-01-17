<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\BatchStudent;

class TestResultController extends Controller
{
    /**
     * All batches result
     */
    public function batches()
    {
        $student = auth()->user()->student;

        $batches = Batch::whereIn(
            'id',
            BatchStudent::where('student_id', $student->id)->pluck('batch_id')
        )->get();

        return view('student.results.batches', compact('batches'));
    }

    /**
     * Batch → Tests
     */
    public function tests(Batch $batch)
    {
        $student = auth()->user()->student;

        $batchStudent = BatchStudent::where([
            'student_id' => $student->id,
            'batch_id' => $batch->id
        ])->firstOrFail();

        $tests = Test::where('batch_id', $batch->id)
            ->withCount('questions')
            ->get();

        return view('student.results.tests', compact('batch', 'tests'));
    }

    /**
     * Test → Attempts
     */
    public function attempts(Test $test)
    {
        $student = auth()->user()->student;

        $batchStudent = BatchStudent::where([
            'student_id' => $student->id,
            'batch_id' => $test->batch_id
        ])->firstOrFail();

        $attempts = TestAttempt::where([
            'test_id' => $test->id,
            'batch_student_id' => $batchStudent->id,
        ])->latest()->get();

        return view('student.results.attempts', compact('test', 'attempts'));
    }

    /**
     * Attempt Detail
     */
    public function attemptDetail(TestAttempt $attempt)
{
    $student = auth()->user()->student;

    // 🔐 Security: student sirf apna attempt dekhe
    if ($attempt->batchStudent->student_id !== $student->id) {
        abort(403);
    }

    // Load relations
    $attempt->load([
        'test',
        'answers.question'
    ]);

    return view('student.results.attempt-detail', compact('attempt'));
}

    
}

