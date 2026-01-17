<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Test;
use App\Models\Question;
use App\Models\TestAttempt;
use App\Models\TestAnswer;
use App\Models\BatchStudent;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /* ================= TEST LIST ================= */
    public function index(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $tests = Test::where('batch_id', $batch->id)
            ->withCount('questions')
            ->latest()
            ->get();

        return view('teacher.tests.index', compact('batch', 'tests'));
    }

    /* ================= CREATE TEST ================= */
    public function create(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        return view('teacher.tests.create', compact('batch'));
    }

    public function store(Request $request, Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $request->validate([
            'title'        => 'required',
            'test_type'    => 'required',
            'mode'         => 'required',
            'total_marks'  => 'required|numeric',
        ]);

        Test::create([
            'batch_id'    => $batch->id,
            'subject_id'  => $batch->subject_id,
            'title'       => $request->title,
            'test_type'   => $request->test_type,
            'mode'        => $request->mode,
            'total_marks' => $request->total_marks,
            'duration'    => $request->duration,
        ]);

        return redirect()
            ->route('teacher.batches.tests', $batch)
            ->with('success', 'Test created successfully');
    }

    /* ================= QUESTIONS ================= */
    public function questions(Test $test)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        return view('teacher.tests.questions', [
            'test' => $test,
            'questions' => $test->questions
        ]);
    }

    public function storeQuestion(Request $request, Test $test)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $request->validate([
            'question'        => 'required',
            'option_a'        => 'required',
            'option_b'        => 'required',
            'option_c'        => 'required',
            'option_d'        => 'required',
            'correct_option'  => 'required',
            'marks'           => 'required|numeric',
        ]);

        Question::create([
            'test_id'        => $test->id,
            'question'       => $request->question,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'correct_option' => $request->correct_option,
            'marks'          => $request->marks,
            'negative_marks' => $request->negative_marks ?? 0,
            'explanation'    => $request->explanation,
        ]);

        return back()->with('success', 'Question added');
    }

    /* ================= PUBLISH ================= */
    public function togglePublish(Test $test)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $test->update([
            'is_published' => ! $test->is_published
        ]);

        return back()->with('success', 'Test status updated');
    }

    /* ================= RESULTS ================= */
    public function results(Batch $batch)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $tests = Test::where('batch_id', $batch->id)
            ->withCount(['questions', 'attempts'])
            ->withAvg('attempts', 'score')
            ->withMax('attempts', 'score')
            ->latest()
            ->get();

        return view('teacher.tests.results', compact('batch', 'tests'));
    }

    public function studentResults(Test $test)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $students = $test->batch
            ->students()
            ->with([
                'student.user',
                'testAttempts' => function ($q) use ($test) {
                    $q->where('test_id', $test->id)->latest();
                }
            ])
            ->get();

        return view('teacher.tests.student-results', compact('test', 'students'));
    }

    public function studentResultDetail(Test $test, BatchStudent $batchStudent)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        if ((int)$batchStudent->batch_id !== (int)$test->batch_id) {
            abort(403);
        }

        $attempts = TestAttempt::where([
                'test_id' => $test->id,
                'batch_student_id' => $batchStudent->id,
            ])
            ->orderByDesc('attempt_no')
            ->get();

        return view(
            'teacher.tests.student-result-detail',
            compact('test', 'batchStudent', 'attempts')
        );
    }

    public function attemptAnswers(TestAttempt $attempt)
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher || (int)$attempt->test->batch->teacher_id !== (int)$teacher->id) {
            abort(403);
        }

        $attempt->load([
            'test',
            'answers.question',
            'batchStudent.student.user'
        ]);

        return view(
            'teacher.tests.attempt-answers',
            compact('attempt')
        );
    }
}
