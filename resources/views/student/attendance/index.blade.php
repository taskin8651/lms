@extends('student.layout')

@section('page-title', 'My Attendance')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">
        Attendance History
    </h2>
    <p class="text-sm text-gray-500">
        Track your daily attendance
    </p>
</div>

<!-- ================= FILTER ================= -->
<form method="GET" class="bg-white border rounded-xl p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <input type="date"
               name="date"
               value="{{ request('date') }}"
               class="border rounded px-3 py-2 text-sm">

        <select name="status"
                class="border rounded px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="present" {{ request('status')=='present' ? 'selected' : '' }}>Present</option>
            <option value="absent" {{ request('status')=='absent' ? 'selected' : '' }}>Absent</option>
        </select>

        <button class="bg-blue-600 text-white rounded px-4 py-2 text-sm">
            Filter
        </button>

    </div>
</form>

<!-- ================= TABLE ================= -->
<div class="bg-white rounded-2xl border shadow-sm overflow-x-auto">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Date</th>
                <th class="p-4 text-left">Batch</th>
                <th class="p-4 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($attendances as $attendance)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">
                    {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}
                </td>

                <td class="p-4">
                    {{ $attendance->batch_student->batch->name ?? '-' }}
                </td>

                <td class="p-4">
                    <span class="px-3 py-1 text-xs rounded-full font-medium
                        {{ $attendance->status === 'present'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="p-6 text-center text-gray-500">
                    No attendance records found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

<!-- ================= PAGINATION ================= -->
<div class="mt-6">
    {{ $attendances->links() }}
</div>

@endsection
