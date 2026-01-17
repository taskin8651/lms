@extends('teacher.layout')

@section('page-title', 'Create Test')

@section('content')

<form method="POST"
      action="{{ route('teacher.batches.tests.store', $batch) }}"
      class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl space-y-4">
@csrf

<h2 class="text-lg font-semibold text-gray-800 mb-4">
    Create New Test
</h2>

<input
    name="title"
    placeholder="Test Title"
    class="w-full border rounded px-3 py-2"
    required>

<select name="test_type" class="w-full border rounded px-3 py-2">
    <option value="">Select Test Type</option>
    <option value="class">Class Test</option>
    <option value="unit">Unit Test</option>
    <option value="mock">Mock Test</option>
</select>

<select name="mode" class="w-full border rounded px-3 py-2">
    <option value="exam">Exam Mode</option>
    <option value="practice">Practice Mode</option>
</select>

<input
    type="number"
    name="total_marks"
    placeholder="Total Marks"
    class="w-full border rounded px-3 py-2"
    required>

<input
    name="duration"
    placeholder="Duration (minutes)"
    class="w-full border rounded px-3 py-2">

<div class="flex gap-3">
    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
        Save Test
    </button>

    <a href="{{ route('teacher.batches.tests', $batch) }}"
       class="px-6 py-2 border rounded-lg">
        Cancel
    </a>
</div>

</form>

@endsection
