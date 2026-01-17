@extends('student.layout')

@section('page-title', 'Test Result')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            {{ $attempt->test->title }}
        </h2>
        <p class="text-sm text-gray-500">
            Attempt #{{ $attempt->attempt_no }} • Result Details
        </p>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">

        <div class="bg-white border rounded-xl p-4 text-center">
            <p class="text-sm text-gray-500">Score</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $attempt->score }}
            </p>
        </div>

        <div class="bg-white border rounded-xl p-4 text-center">
            <p class="text-sm text-gray-500">Correct</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $attempt->correct }}
            </p>
        </div>

        <div class="bg-white border rounded-xl p-4 text-center">
            <p class="text-sm text-gray-500">Wrong</p>
            <p class="text-2xl font-bold text-red-600">
                {{ $attempt->wrong }}
            </p>
        </div>

        <div class="bg-white border rounded-xl p-4 text-center">
            <p class="text-sm text-gray-500">Percentage</p>
            <p class="text-2xl font-bold text-purple-600">
                {{ $attempt->percentage }}%
            </p>
        </div>

    </div>

    <!-- QUESTION REVIEW -->
    <div class="bg-white border rounded-xl shadow-sm">

        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">
                Question-wise Review
            </h3>
        </div>

        <div class="divide-y">

            @foreach($attempt->answers as $index => $answer)

                <div class="p-6">

                    <!-- QUESTION -->
                    <p class="font-medium text-gray-800 mb-3">
                        Q{{ $index + 1 }}. {{ $answer->question->question }}
                    </p>

                    <!-- OPTIONS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mb-4">
                        <p>A. {{ $answer->question->option_a }}</p>
                        <p>B. {{ $answer->question->option_b }}</p>
                        <p>C. {{ $answer->question->option_c }}</p>
                        <p>D. {{ $answer->question->option_d }}</p>
                    </div>

                    <!-- ANSWERS -->
                    <div class="text-sm space-y-1">
                        <p>
                            <strong>Your Answer:</strong>
                            <span class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                {{ strtoupper($answer->selected_option ?? '-') }}
                            </span>
                        </p>

                        <p>
                            <strong>Correct Answer:</strong>
                            {{ strtoupper($answer->question->correct_option) }}
                        </p>

                        <p>
                            <strong>Marks:</strong>
                            {{ $answer->marks_obtained }}
                        </p>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <!-- BACK -->
    <div class="mt-6 text-center">
        <a href="{{ route('student.tests') }}"
           class="text-blue-600 text-sm hover:underline">
            ← Back to Tests
        </a>
    </div>

</div>

@endsection
