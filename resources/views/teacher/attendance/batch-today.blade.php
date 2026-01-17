@extends('teacher.layout')

@section('page-title', 'Today Attendance')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ $batch->name }} – Today Attendance
    </h2>
    <p class="text-sm text-gray-500">
        {{ date('d M Y') }}
    </p>
</div>

<!-- ================= SUMMARY ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-gray-500">Present</p>
        <p class="text-3xl font-bold text-green-600">
            {{ $summary['present'] }}
        </p>
    </div>

    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <p class="text-gray-500">Absent</p>
        <p class="text-3xl font-bold text-red-600">
            {{ $summary['absent'] }}
        </p>
    </div>

</div>

<!-- ================= STUDENT LIST ================= -->
<div class="bg-white rounded-lg shadow-sm border overflow-x-auto">

   <table class="w-full text-sm">
    <thead class="bg-gray-50 border-b">
        <tr>
            <th class="p-4 text-left">Student</th>
            <th class="p-4 text-left">Mobile</th>
            <th class="p-4 text-left">Status</th>
            <th class="p-4 text-left">History</th>
        </tr>
    </thead>

    <tbody>
        @forelse($attendances as $attendance)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4 font-medium">
                    {{ $attendance->batch_student->student->user->name ?? '-' }}
                </td>

                <td class="p-4">
                    {{ $attendance->batch_student->student->mobile ?? '-' }}
                </td>

                <td class="p-4">
                    <span class="px-3 py-1 text-xs rounded-full font-medium
                        {{ $attendance->status === 'present'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>

                <!-- HISTORY BUTTON -->
                <td class="p-4">
                    <a href="{{ route(
                        'teacher.batches.students.attendance.history',
                        [$batch->id, $attendance->batch_student->student_id]
                    ) }}"
                       class="text-blue-600 hover:underline text-sm font-medium">
                        View History →
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    No attendance marked today.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


</div>

<!-- ================= BACK ================= -->
<div class="mt-6">
    <a href="{{ route('teacher.attendance') }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back to Attendance
    </a>
</div>

@endsection
