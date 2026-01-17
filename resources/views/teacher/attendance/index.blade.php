@extends('teacher.layout')

@section('page-title', 'Attendance')

@section('content')

<!-- ================= HEADER ================= -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            Attendance
        </h2>
        <p class="text-sm text-gray-500">
            All attendance records
        </p>
    </div>
</div>

<!-- ================= FILTER ================= -->
<form method="GET" class="bg-white border rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- Date -->
        <input
            type="date"
            name="date"
            value="{{ request('date') }}"
            class="border rounded px-3 py-2 text-sm">

        <!-- Status -->
        <select name="status" class="border rounded px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="present" {{ request('status')=='present' ? 'selected' : '' }}>Present</option>
            <option value="absent" {{ request('status')=='absent' ? 'selected' : '' }}>Absent</option>
        </select>

        <!-- Student name -->
        <input
            type="text"
            name="student"
            value="{{ request('student') }}"
            placeholder="Student name"
            class="border rounded px-3 py-2 text-sm">

        <button class="bg-blue-600 text-white rounded px-4 py-2 text-sm">
            Filter
        </button>
    </div>
</form>
<!-- ================= BATCH SUMMARY ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

@forelse($batchSummary as $row)
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">

        <!-- HEADER -->
        <div class="flex items-start justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 leading-tight">
                {{ $row->batch_name }}
            </h3>

            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                Today
            </span>
        </div>

        <!-- COUNTS -->
        <div class="grid grid-cols-2 gap-4 mb-5">

            <div class="bg-green-50 rounded-xl p-4 text-center">
                <p class="text-xs text-green-700 mb-1">Present</p>
                <p class="text-3xl font-bold text-green-700">
                    {{ $row->present_count }}
                </p>
            </div>

            <div class="bg-red-50 rounded-xl p-4 text-center">
                <p class="text-xs text-red-700 mb-1">Absent</p>
                <p class="text-3xl font-bold text-red-700">
                    {{ $row->absent_count }}
                </p>
            </div>

        </div>

        <!-- ACTION -->
        <a href="{{ route('teacher.batches.attendance.today', $row->batch_id) }}"
           class="block w-full text-center bg-blue-600 text-white text-sm font-medium py-2.5 rounded-xl hover:bg-blue-700 transition">
            View Today Attendance →
        </a>

    </div>
@empty
    <div class="col-span-full text-center text-gray-500 py-10">
        No batch data available.
    </div>
@endforelse

</div>




@endsection
