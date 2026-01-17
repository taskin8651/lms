@extends('teacher.layout')

@section('page-title', 'Dashboard')

@section('content')

<!-- GREETING -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-800">
        Welcome back, {{ auth()->user()->name }} 👋
    </h1>
    <p class="text-sm text-gray-500">
        Quick overview of your teaching activities
    </p>
</div>

<!-- QUICK ACTIONS -->
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-10">
    <a href="{{ route('teacher.batches') }}" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        📚 <p class="mt-2 text-sm font-semibold">Batches</p>
    </a>
    <a href="{{ route('teacher.attendance') }}" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        📝 <p class="mt-2 text-sm font-semibold">Attendance</p>
    </a>
    <a href="{{ route('teacher.batches') }}" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        🎥 <p class="mt-2 text-sm font-semibold">Live Classes</p>
    </a>
    <a href="{{ route('teacher.batches') }}" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        🧪 <p class="mt-2 text-sm font-semibold">Tests</p>
    </a>
    <a href="{{ route('teacher.batches') }}" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        📊 <p class="mt-2 text-sm font-semibold">Results</p>
    </a>
    <a href="#" class="bg-white border rounded-xl p-4 text-center hover:shadow">
        ⚙️ <p class="mt-2 text-sm font-semibold">Profile</p>
    </a>
</div>

<!-- STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <div class="bg-white border rounded-2xl p-6">
        <p class="text-sm text-gray-500">My Batches</p>
        <p class="text-4xl font-bold text-blue-600 mt-2">{{ $batches->count() }}</p>
    </div>
    <div class="bg-white border rounded-2xl p-6">
        <p class="text-sm text-gray-500">Total Students</p>
        <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalStudents }}</p>
    </div>
    <div class="bg-white border rounded-2xl p-6">
        <p class="text-sm text-gray-500">Today Classes</p>
        <p class="text-4xl font-bold text-purple-600 mt-2">{{ $todayClasses->count() }}</p>
    </div>
    <div class="bg-white border rounded-2xl p-6">
        <p class="text-sm text-gray-500">Attendance Marked</p>
        <p class="text-4xl font-bold text-orange-500 mt-2">{{ $todayAttendance }}</p>
    </div>
</div>

<!-- TODAY CLASSES -->
<div class="bg-white rounded-2xl border">
    <div class="px-6 py-4 border-b">
        <h2 class="font-semibold text-gray-800">Today’s Live Classes</h2>
    </div>

    <div class="divide-y">
        @forelse($todayClasses as $class)
            <div class="px-6 py-4 flex justify-between">
                <div>
                    <p class="font-medium">{{ $class->topic }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $class->start_time }} – {{ $class->end_time }}
                    </p>
                </div>
                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                    Scheduled
                </span>
            </div>
        @empty
            <p class="px-6 py-6 text-sm text-gray-500 text-center">
                No live class today
            </p>
        @endforelse
    </div>
</div>

@endsection
