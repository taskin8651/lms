@extends('teacher.layout')

@section('page-title', 'Tests')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $batch->name }} – Tests
        </h2>
        <p class="text-sm text-gray-500">
            👉 Step 1: Create Test → Step 2: Add Questions → Step 3: Publish
        </p>
    </div>

    <a href="{{ route('teacher.batches.tests.create', $batch) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Create Test
    </a>
</div>

<!-- TEST LIST -->
<div class="bg-white rounded-xl shadow-sm border overflow-x-auto">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Type</th>
                <th class="p-4 text-left">Mode</th>
                <th class="p-4 text-left">Questions</th>
                <th class="p-4 text-left">Marks</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($tests as $test)
            <tr class="border-b hover:bg-gray-50 align-top">

                <!-- TITLE -->
                <td class="p-4 font-medium text-gray-800">
                    {{ $test->title ?? 'Untitled Test' }}
                </td>

                <!-- TYPE -->
                <td class="p-4">
                    {{ ucfirst($test->test_type) }}
                </td>

                <!-- MODE -->
                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $test->mode === 'practice'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($test->mode) }}
                    </span>
                </td>

                <!-- QUESTIONS -->
                <td class="p-4">
                    <span class="font-semibold">
                        {{ $test->questions_count }}
                    </span>
                </td>

                <!-- MARKS -->
                <td class="p-4">
                    {{ $test->total_marks }}
                </td>

                <!-- STATUS -->
                <td class="p-4">
                    @if($test->questions_count == 0)
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                            No Questions
                        </span>
                    @elseif(!$test->is_published)
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                            Ready (Draft)
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                            Published
                        </span>
                    @endif
                </td>

                <!-- ACTIONS -->
                <td class="p-4 space-y-2">

                    <!-- MANAGE QUESTIONS -->
                    <a href="{{ route('teacher.tests.questions', $test) }}"
                       class="block text-blue-600 text-sm font-medium hover:underline">
                        ➕ Add / Manage Questions
                    </a>

                    <!-- PUBLISH -->
                    <form method="POST"
                          action="{{ route('teacher.tests.toggle-publish', $test) }}">
                        @csrf
                        <button
                            class="text-xs px-3 py-1 rounded
                            {{ $test->is_published
                                ? 'bg-red-100 text-red-700'
                                : 'bg-green-100 text-green-700' }}">
                            {{ $test->is_published ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-8 text-center text-gray-500">
                    No tests created yet.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

@endsection
