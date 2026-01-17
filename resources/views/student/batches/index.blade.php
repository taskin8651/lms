@extends('student.layout')

@section('page-title', 'My Batches')

@section('content')

<!-- HEADER -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-gray-800">
        My Batches
    </h2>
    <p class="text-sm text-gray-500">
        All batches you are enrolled in
    </p>
</div>

<!-- BATCH GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

@forelse($batches as $batch)
    <div class="bg-white border rounded-2xl shadow-sm hover:shadow-md transition">

        <div class="p-6">

            <!-- TITLE -->
            <h3 class="text-lg font-semibold text-gray-800 mb-1">
                {{ $batch->name }}
            </h3>

            <p class="text-sm text-gray-500 mb-4">
                {{ $batch->class_level->name ?? '-' }} • {{ $batch->subject->name ?? '-' }}
            </p>

            <!-- DETAILS -->
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Teacher</span>
                    <span class="font-medium">
                        {{ $batch->teacher->user->name ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>Timing</span>
                    <span class="font-medium">
                        {{ $batch->timing ?? '-' }}
                    </span>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="mt-6 flex justify-between items-center">

                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                    Active
                </span>

                <a href="{{ route('student.batches.show', $batch) }}"
                   class="text-sm text-blue-600 hover:underline font-medium">
                    View →
                </a>
            </div>

        </div>
    </div>
@empty
    <div class="col-span-full text-center text-gray-500 py-16">
        You are not enrolled in any batch yet.
    </div>
@endforelse

</div>

@endsection
