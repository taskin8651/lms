@extends('student.layout')

@section('page-title','My Results')

@section('content')

<h2 class="text-xl font-semibold mb-6">My Batches</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($batches as $batch)
    <a href="{{ route('student.results.batch', $batch) }}"
       class="bg-white border rounded-xl p-6 hover:shadow-md">
        <h3 class="font-semibold text-gray-800">
            {{ $batch->name }}
        </h3>
        <p class="text-sm text-gray-500 mt-1">
            View Tests →
        </p>
    </a>
@endforeach

</div>
@endsection
