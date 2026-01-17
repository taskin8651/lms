@extends('teacher.layout')

@section('page-title', 'Attendance History')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ $student->user->name }} – Attendance History
    </h2>
    <p class="text-sm text-gray-500">
        Batch: {{ $batch->name }}
    </p>
</div>

<!-- CALENDAR -->
<div class="bg-white rounded-2xl shadow-sm border p-5">
    <div id="attendanceCalendar"></div>
</div>

<!-- BACK -->
<div class="mt-6">
    <a href="{{ route('teacher.batches.attendance.today', $batch->id) }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back to Today Attendance
    </a>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('attendanceCalendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',

        events: [
            @foreach($attendances as $attendance)
            {
                title: "{{ ucfirst($attendance->status) }}",
                start: "{{ \Carbon\Carbon::parse($attendance->attendance_date)->toDateString() }}",
                backgroundColor: "{{ $attendance->status === 'present' ? '#16a34a' : '#dc2626' }}",
                borderColor: "{{ $attendance->status === 'present' ? '#16a34a' : '#dc2626' }}",
                extendedProps: {
                    punchIn: "{{ $attendance->punch_in_time ?? '-' }}",
                    punchOut: "{{ $attendance->punch_out_time ?? '-' }}"
                }
            },
            @endforeach
        ],

        eventClick: function(info) {
            alert(
                "Status: " + info.event.title +
                "\nPunch In: " + info.event.extendedProps.punchIn +
                "\nPunch Out: " + info.event.extendedProps.punchOut
            );
        }
    });

    calendar.render();
});
</script>

@endsection
