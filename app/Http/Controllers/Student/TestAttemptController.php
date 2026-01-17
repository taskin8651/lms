<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestAnswer;
use App\Models\BatchStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestAttemptController extends Controller
{
    /**
     * Available Tests for Student
     */
    public function index()
    {
        $student = auth()->user()->student;

        $batchIds = BatchStudent::where('student_id', $student->id)
            ->pluck('batch_id');

        $tests = Test::whereIn('batch_id', $batchIds)
            ->where('is_published', 1)
            ->withCount('questions')
            ->latest()
            ->get();

        return view('student.tests.index', compact('tests'));
    }

    /**
     * Start Test
     */
  public function start(Test $test)
{
    $student = auth()->user()->student;

    $batchStudent = BatchStudent::where([
        'student_id' => $student->id,
        'batch_id'   => $test->batch_id,
    ])->firstOrFail();

    // Check existing in-progress attempt
    $attempt = TestAttempt::where([
        'test_id' => $test->id,
        'batch_student_id' => $batchStudent->id,
        'status' => 'in_progress',
    ])->latest()->first();

    // ✅ If no attempt exists, create new
    if (!$attempt) {
        $attemptNo = TestAttempt::where([
            'test_id' => $test->id,
            'batch_student_id' => $batchStudent->id,
        ])->count() + 1;

        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'batch_student_id' => $batchStudent->id,
            'attempt_no' => $attemptNo,
            'total_questions' => $test->questions()->count(),
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
    }

    // Random order only first time (optional improvement later)
    $questions = $test->questions()->inRandomOrder()->get();

    return view('student.tests.start', compact(
        'test',
        'attempt',
        'questions'
    ));
}


    /**
     * Submit Test
     */
    public function submit(Request $request, Test $test)
    {
        $student = auth()->user()->student;

        $batchStudent = BatchStudent::where([
            'student_id' => $student->id,
            'batch_id'   => $test->batch_id,
        ])->firstOrFail();

        $attempt = TestAttempt::where([
            'test_id' => $test->id,
            'batch_student_id' => $batchStudent->id,
            'status' => 'in_progress',
        ])->latest()->firstOrFail();

        DB::transaction(function () use ($request, $test, $attempt) {

            $correct = 0;
            $wrong = 0;
            $attempted = 0;
            $score = 0;

            foreach ($test->questions as $question) {

                $selected = $request->answers[$question->id] ?? null;

                if ($selected !== null) {
                    $attempted++;
                }

                $isCorrect = $selected === $question->correct_option;

                if ($isCorrect) {
                    $correct++;
                    $score += $question->marks;
                } elseif ($selected !== null) {
                    $wrong++;
                    $score -= $question->negative_marks ?? 0;
                }

                TestAnswer::create([
                    'test_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_option' => $selected,
                    'is_correct' => $isCorrect,
                    'marks_obtained' => $isCorrect ? $question->marks : 0,
                ]);
            }

            $percentage = $attempt->total_questions > 0
                ? round(($correct / $attempt->total_questions) * 100, 2)
                : 0;

            $attempt->update([
                'attempted' => $attempted,
                'correct' => $correct,
                'wrong' => $wrong,
                'score' => max($score, 0), // prevent negative total
                'percentage' => $percentage,
                'status' => 'completed', // ✅ ENUM SAFE
                'submitted_at' => now(),
            ]);
        });

        return redirect()
            ->route('student.tests')
            ->with('success', 'Test submitted successfully!');
    }

   

}
