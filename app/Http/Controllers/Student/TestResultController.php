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
     * Student → All Batches (Result Section)
     */
    public function batches()
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403);
        }

        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        $batches = Batch::whereIn('id', $batchIds)
            ->with(['teacher.user', 'subject', 'class_level'])
            ->latest()
            ->get();

        return view('student.results.batches', compact('batches'));
    }

    /**
     * Batch → Tests
     */
    public function tests(Batch $batch)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403);
        }

        // 🔒 Ensure student is enrolled in batch
        BatchStudent::where([
            'student_id' => $student->id,
            'batch_id'   => $batch->id,
        ])->firstOrFail();

        $tests = Test::where('batch_id', $batch->id)
            ->withCount('questions')
            ->latest()
            ->get();

        return view('student.results.tests', compact('batch', 'tests'));
    }

    /**
     * Test → All Attempts of Student
     */
    public function attempts(Test $test)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403);
        }

        // 🔒 Enrollment check
        $batchStudent = BatchStudent::where([
            'student_id' => $student->id,
            'batch_id'   => $test->batch_id,
        ])->firstOrFail();

        $attempts = TestAttempt::where([
                'test_id' => $test->id,
                'batch_student_id' => $batchStudent->id,
            ])
            ->orderByDesc('attempt_no')
            ->get();

        return view('student.results.attempts', compact('test', 'attempts'));
    }

    /**
     * Attempt → Detailed Result
     */
    public function attemptDetail(TestAttempt $attempt)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403);
        }

        // 🔐 Student sirf apna attempt dekhe
        if ((int) $attempt->batchStudent->student_id !== (int) $student->id) {
            abort(403);
        }

        $attempt->load([
            'test',
            'answers.question',
        ]);

        return view(
            'student.results.attempt-detail',
            compact('attempt')
        );
    }
}
