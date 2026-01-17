@extends('student.layout')

@section('page-title','Test Attempts')

@section('content')

<h2 class="text-xl font-semibold mb-6">
    {{ $test->title }} – Attempts
</h2>

<div class="space-y-4">

@foreach($attempts as $attempt)
<div class="bg-white border rounded-xl p-4 flex justify-between">
    <div>
        <p class="font-medium">
            Attempt #{{ $attempt->attempt_no }}
        </p>
        <p class="text-sm text-gray-500">
            Score: {{ $attempt->score }} | {{ $attempt->percentage }}%
        </p>
    </div>

    <a href="{{ route('student.results.attempt', $attempt) }}"
       class="text-blue-600 text-sm">
        View Detail →
    </a>
</div>
@endforeach

</div>
@endsection
