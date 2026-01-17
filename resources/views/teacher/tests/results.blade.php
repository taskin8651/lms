@extends('teacher.layout')

@section('page-title', 'Test Results')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $batch->name }} – Test Results
        </h2>
        <p class="text-sm text-gray-500">
            Student performance overview
        </p>
    </div>

    <a href="{{ route('teacher.batches.tests', $batch) }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back to Tests
    </a>
</div>

<!-- RESULT TABLE -->
<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Test</th>
                <th class="p-4 text-left">Mode</th>
                <th class="p-4 text-left">Questions</th>
                <th class="p-4 text-left">Attempts</th>
                <th class="p-4 text-left">Avg Score</th>
                <th class="p-4 text-left">Top Score</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($tests as $test)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4 font-medium">
                    {{ $test->title }}
                </td>

                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $test->mode === 'practice'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($test->mode) }}
                    </span>
                </td>

                <td class="p-4">
                    {{ $test->questions_count }}
                </td>

                <td class="p-4">
                    {{ $test->attempts_count }}
                </td>

                <td class="p-4">
                    {{ number_format($test->attempts_avg_score ?? 0, 2) }}
                </td>

                <td class="p-4 font-semibold text-green-700">
                    {{ number_format($test->attempts_max_score ?? 0, 2) }}
                </td>

                <td class="p-4">
                    <a href="{{ route('teacher.tests.results.students', $test) }}"
                       class="text-sm text-blue-600 hover:underline">
                        View Students →
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-6 text-center text-gray-500">
                    No test results available yet.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

</div>

@endsection
