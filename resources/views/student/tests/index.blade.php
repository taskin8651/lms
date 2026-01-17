@extends('student.layout')

@section('page-title', 'Available Tests')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@forelse($tests as $test)
    <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition">

        <h3 class="text-lg font-semibold text-gray-800">
            {{ $test->title }}
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            {{ ucfirst($test->test_type) }} • {{ ucfirst($test->mode) }}
        </p>

        <p class="text-sm text-gray-600 mt-2">
            Questions: {{ $test->questions_count }}
        </p>

        <a href="{{ route('student.tests.start', $test) }}"
           class="mt-4 block w-full text-center bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">
            Start Test →
        </a>

    </div>
@empty
    <div class="col-span-full text-center text-gray-500 py-12">
        No tests available right now.
    </div>
@endforelse

</div>

@endsection
