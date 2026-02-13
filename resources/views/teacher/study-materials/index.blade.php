@extends('teacher.layout')

@section('page-title', 'Study Materials')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">
        {{ $batch->name }} – Study Materials
    </h2>

    <a href="{{ route('teacher.batches.materials.create', $batch) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
        + Add Material
    </a>
</div>

<div class="bg-white rounded-xl shadow border overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Chapter</th>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Type</th>
                <th class="p-4 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($materials as $material)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">
                        {{ $material->chapter->name }}
                    </td>
                    <td class="p-4 font-medium">
                        {{ $material->title }}
                    </td>
                    <td class="p-4">
                        @if($material->file)
                            📄 File
                        @elseif($material->video_link)
                            🎥 Video
                        @else
                            —
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $material->status === 'active'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($material->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">
                        No materials added yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
