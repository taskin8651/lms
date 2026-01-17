@extends('student.layout')

@section('page-title', 'Live Classes')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">
        Live Classes
    </h2>
    <p class="text-sm text-gray-500">
        Join your scheduled live sessions
    </p>
</div>

<!-- ================= TODAY CLASSES ================= -->
@if($todayClasses->count())
<div class="bg-white rounded-2xl border shadow-sm mb-8">

    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-gray-800">
            🔴 Today’s Live Classes
        </h3>
    </div>

    <div class="divide-y">
        @foreach($todayClasses as $class)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">
                        {{ $class->topic ?? 'Live Class' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $class->batch->name ?? '-' }} •
                        {{ $class->start_time }} – {{ $class->end_time }}
                    </p>
                </div>

                <a href="{{ $class->meeting_link }}"
                   target="_blank"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    Join Now
                </a>
            </div>
        @endforeach
    </div>

</div>
@endif

<!-- ================= ALL CLASSES ================= -->
<div class="bg-white rounded-2xl border shadow-sm">

    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-gray-800">
            All Live Classes
        </h3>
    </div>

    <div class="divide-y">
        @forelse($liveClasses as $class)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">
                        {{ $class->topic ?? 'Live Class' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $class->batch->name ?? '-' }} •
                        {{ $class->class_date }}
                    </p>
                </div>

                <div class="flex gap-2">
                    @if($class->meeting_link)
                        <a href="{{ $class->meeting_link }}"
                           target="_blank"
                           class="px-3 py-1.5 text-sm rounded-lg
                           bg-blue-100 text-blue-700 hover:bg-blue-200">
                            Join
                        </a>
                    @endif

                    @if($class->recording_link)
                        <a href="{{ $class->recording_link }}"
                           target="_blank"
                           class="px-3 py-1.5 text-sm rounded-lg
                           bg-purple-100 text-purple-700 hover:bg-purple-200">
                            Recording
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">
                No live classes available.
            </div>
        @endforelse
    </div>

</div>

@endsection
