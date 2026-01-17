@extends('student.layout')

@section('page-title', 'My Batch')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">
        {{ $batch->name }}
    </h2>
    <p class="text-sm text-gray-500">
        {{ $batch->class_level->name ?? '-' }} • {{ $batch->subject->name ?? '-' }}
    </p>
</div>

<!-- ================= QUICK STATS ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-sm text-gray-500">Teacher</p>
        <p class="text-lg font-semibold text-gray-800 mt-1">
            {{ $batch->teacher->user->name ?? '-' }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-sm text-gray-500">Batch Timing</p>
        <p class="text-lg font-semibold text-gray-800 mt-1">
            {{ $batch->timing ?? '-' }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-sm text-gray-500">Status</p>
        <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full font-medium
            {{ $batch->status === 'active'
                ? 'bg-green-100 text-green-700'
                : 'bg-gray-100 text-gray-600' }}">
            {{ ucfirst($batch->status) }}
        </span>
    </div>

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-sm text-gray-500">Fees</p>
        <p class="text-lg font-semibold text-gray-800 mt-1">
            ₹ {{ $batch->fees_amount ?? 'N/A' }}
        </p>
    </div>

</div>

<!-- ================= ACTION CARDS ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

    <!-- Attendance -->
    <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            📋 Attendance
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            View your daily attendance & history
        </p>
        <a href="{{ route('student.attendance') }}"
           class="inline-block text-sm text-blue-600 font-medium hover:underline">
            View Attendance →
        </a>
    </div>

    <!-- Live Classes -->
    <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            🎥 Live Classes
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            Join upcoming & recorded live classes
        </p>
        <a href="{{ route('student.live-classes') }}"
           class="inline-block text-sm text-blue-600 font-medium hover:underline">
            View Live Classes →
        </a>
    </div>

    <!-- Tests -->
   <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition">
    <h3 class="text-lg font-semibold text-gray-800 mb-2">
        🧪 Tests & Practice
    </h3>

    <p class="text-sm text-gray-500 mb-4">
        Attempt tests & practice questions
    </p>

    <a href="{{ route('student.tests') }}"
       class="inline-flex items-center gap-1 text-sm text-blue-600 font-medium hover:underline">
        View Tests →
    </a>
</div>


</div>

<!-- ================= BACK ================= -->
<a href="{{ route('student.batches') }}"
   class="text-sm text-blue-600 hover:underline">
    ← Back to My Batches
</a>

@endsection
