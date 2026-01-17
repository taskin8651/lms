@extends('teacher.layout')

@section('page-title', 'Live Classes')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-semibold">{{ $batch->name }}</h2>
        <p class="text-sm text-gray-500">Live Classes</p>
    </div>

    <a href="{{ route('teacher.batches.live-classes.create', $batch->id) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Schedule Class
    </a>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Date</th>
                <th class="p-4 text-left">Time</th>
                <th class="p-4 text-left">Topic</th>
                <th class="p-4 text-left">Type</th>
                <th class="p-4 text-left">Join</th>
            </tr>
        </thead>

        <tbody>
            @forelse($liveClasses as $class)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $class->class_date }}</td>
                    <td class="p-4">{{ $class->start_time }} - {{ $class->end_time }}</td>
                    <td class="p-4 font-medium">{{ $class->topic }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs rounded bg-gray-100">
                            {{ strtoupper(str_replace('_',' ', $class->class_type)) }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($class->meeting_link)
                            <a href="{{ $class->meeting_link }}"
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                Join
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No live classes scheduled.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
