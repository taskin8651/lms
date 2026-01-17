@extends('student.layout')

@section('page-title','Batch Results')

@section('content')

<h2 class="text-xl font-semibold mb-6">
    {{ $batch->name }} – Tests
</h2>

<div class="bg-white border rounded-xl overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-50">
<tr>
    <th class="p-4">Test</th>
    <th class="p-4">Questions</th>
    <th class="p-4">Action</th>
</tr>
</thead>

<tbody>
@foreach($tests as $test)
<tr class="border-b">
    <td class="p-4">{{ $test->title }}</td>
    <td class="p-4">{{ $test->questions_count }}</td>
    <td class="p-4">
        <a href="{{ route('student.results.test', $test) }}"
           class="text-blue-600 text-sm">
            View Attempts →
        </a>
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
@endsection
