@extends('student.layout')

@section('page-title', 'Dashboard')

@section('content')

<!-- ================= GREETING ================= -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-800">
        Welcome, {{ auth()->user()->name }} 👋
    </h1>
    <p class="text-sm text-gray-500">
        Track your classes, attendance & tests
    </p>
</div>

<!-- ================= STATS ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">My Batches</p>
        <p class="text-4xl font-bold text-blue-600 mt-2">
            {{ count($batchIds) }}
        </p>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Attendance</p>
        <p class="text-4xl font-bold text-green-600 mt-2">
            {{ $attendancePercent }}%
        </p>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Live Classes Today</p>
        <p class="text-4xl font-bold text-purple-600 mt-2">
            {{ $todayClasses->count() }}
        </p>
    </div>

    <div class="bg-white border rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">Upcoming Tests</p>
        <p class="text-4xl font-bold text-orange-500 mt-2">
            {{ $upcomingTests->count() }}
        </p>
    </div>

</div>

<!-- ================= TODAY CLASSES ================= -->
<div class="bg-white rounded-2xl border shadow-sm mb-10">

    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">
            Today’s Live Classes
        </h2>
    </div>

    <div class="divide-y">
        @forelse($todayClasses as $class)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">
                        {{ $class->topic ?? 'Live Class' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $class->start_time }} – {{ $class->end_time }}
                    </p>
                </div>

                <a href="{{ $class->meeting_link }}"
                   target="_blank"
                   class="text-sm text-blue-600 hover:underline">
                    Join →
                </a>
            </div>
        @empty
            <div class="px-6 py-6 text-center text-gray-500 text-sm">
                No live class today 🎉
            </div>
        @endforelse
    </div>

</div>

<!-- ================= UPCOMING TESTS ================= -->
<div class="bg-white rounded-2xl border shadow-sm">

    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">
            Upcoming Tests
        </h2>
    </div>

    <div class="divide-y">
        @forelse($upcomingTests as $test)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">
                        {{ $test->title }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ ucfirst($test->mode) }} • {{ ucfirst($test->test_type) }}
                    </p>
                </div>

                <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700">
                    Ready
                </span>
            </div>
        @empty
            <div class="px-6 py-6 text-center text-gray-500 text-sm">
                No upcoming tests
            </div>
        @endforelse
    </div>

</div>

@endsection
