@extends('teacher.layout')

@section('page-title', 'Student Test Result')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ $batchStudent->student->user->name }}
    </h2>
    <p class="text-sm text-gray-500">
        {{ $test->title }} • {{ $test->batch->name }}
    </p>
</div>

<!-- SUMMARY -->
@if($attempts->count())
@php $latest = $attempts->first(); @endphp

<div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Latest Score</p>
        <p class="text-2xl font-bold text-blue-600">
            {{ $latest->score }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Correct</p>
        <p class="text-2xl font-bold text-green-600">
            {{ $latest->correct }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Wrong</p>
        <p class="text-2xl font-bold text-red-600">
            {{ $latest->wrong }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-4 text-center">
        <p class="text-xs text-gray-500">Percentage</p>
        <p class="text-2xl font-bold text-purple-600">
            {{ $latest->percentage }}%
        </p>
    </div>
</div>
@endif

<!-- ATTEMPT HISTORY -->
<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Attempt</th>
                <th class="p-4 text-left">Score</th>
                <th class="p-4 text-left">Correct</th>
                <th class="p-4 text-left">Wrong</th>
                <th class="p-4 text-left">%</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($attempts as $attempt)
            <tr class="border-b {{ $loop->first ? 'bg-green-50' : '' }}">
                <td class="p-4 font-medium">
                    Attempt #{{ $attempt->attempt_no }}
                </td>

                <td class="p-4">
                    {{ $attempt->score }}
                </td>

                <td class="p-4 text-green-600">
                    {{ $attempt->correct }}
                </td>

                <td class="p-4 text-red-600">
                    {{ $attempt->wrong }}
                </td>

                <td class="p-4">
                    {{ $attempt->percentage }}%
                </td>

                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $attempt->status === 'completed'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($attempt->status) }}
                    </span>
                </td>

                <td class="p-4">
    <a href="{{ route('teacher.tests.attempt.answers', $attempt) }}"
       class="text-sm text-blue-600 hover:underline font-medium">
        View Answers →
    </a>
</td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-gray-500">
                    Student has not attempted this test yet.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

<!-- BACK -->
<div class="mt-6">
    <a href="{{ route('teacher.tests.results.students', $test) }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back to Students
    </a>
</div>

@endsection
