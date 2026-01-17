@extends('teacher.layout')

@section('page-title', 'Answer Sheet')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ $attempt->batchStudent->student->user->name }}
    </h2>
    <p class="text-sm text-gray-500">
        {{ $attempt->test->title }} • Attempt #{{ $attempt->attempt_no }}
    </p>
</div>

<!-- SUMMARY -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Score</p>
        <p class="text-2xl font-bold text-blue-600">
            {{ $attempt->score }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Correct</p>
        <p class="text-2xl font-bold text-green-600">
            {{ $attempt->correct }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Wrong</p>
        <p class="text-2xl font-bold text-red-600">
            {{ $attempt->wrong }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Percentage</p>
        <p class="text-2xl font-bold text-purple-600">
            {{ $attempt->percentage }}%
        </p>
    </div>

</div>

<!-- ANSWER SHEET -->
<div class="space-y-6">

@foreach($attempt->answers as $index => $answer)

<div class="bg-white border rounded-xl p-6 shadow-sm">

    <!-- QUESTION -->
    <p class="font-semibold text-gray-800 mb-3">
        Q{{ $index + 1 }}. {{ $answer->question->question }}
    </p>

    <!-- OPTIONS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mb-4">

        @foreach(['a','b','c','d'] as $opt)

            @php
                $isCorrect = $answer->question->correct_option === $opt;
                $isSelected = $answer->selected_option === $opt;
            @endphp

            <div class="px-3 py-2 rounded border
                {{ $isCorrect ? 'bg-green-50 border-green-400' : '' }}
                {{ $isSelected && ! $isCorrect ? 'bg-red-50 border-red-400' : '' }}
            ">
                <strong>{{ strtoupper($opt) }}.</strong>
                {{ $answer->question->{'option_'.$opt} }}

                @if($isCorrect)
                    <span class="ml-2 text-xs text-green-700 font-semibold">
                        ✔ Correct
                    </span>
                @endif

                @if($isSelected && ! $isCorrect)
                    <span class="ml-2 text-xs text-red-700 font-semibold">
                        ✖ Student Chose
                    </span>
                @endif
            </div>

        @endforeach
    </div>

    <!-- RESULT -->
    <div class="text-sm space-y-1">
        <p>
            <strong>Student Answer:</strong>
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

    @if($answer->question->explanation)
        <div class="mt-3 bg-gray-50 border rounded p-3 text-sm text-gray-700">
            <strong>Explanation:</strong><br>
            {{ $answer->question->explanation }}
        </div>
    @endif

</div>

@endforeach

</div>

<!-- BACK -->
<div class="mt-8">
    <a href="{{ url()->previous() }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back
    </a>
</div>

@endsection
