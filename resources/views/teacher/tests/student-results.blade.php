@extends('teacher.layout')

@section('page-title', 'Student Results')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ $test->title }} – Student Results
    </h2>
    <p class="text-sm text-gray-500">
        Batch-wise performance overview
    </p>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Student</th>
                <th class="p-4 text-left">Mobile</th>
                <th class="p-4 text-left">Attempts</th>
                <th class="p-4 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $row)
                @php
                    $attempt = $row->testAttempts->first();
                @endphp

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium">
                        {{ $row->student->user->name }}
                    </td>

                    <td class="p-4">
                        {{ $row->student->mobile }}
                    </td>

                    <td class="p-4">
                        {{ $row->testAttempts->count() }}
                    </td>

                   <td class="p-4">
    @if($attempt)
        <a href="{{ route(
            'teacher.tests.results.student-detail',
            [$test, $row]
        ) }}"
           class="text-sm text-blue-600 hover:underline font-medium">
            View Result →
        </a>
    @else
        <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
            Not Attempted
        </span>
    @endif
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">
                        No students found in this batch.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
