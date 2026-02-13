@extends('teacher.layout')

@section('page-title', 'Add Study Material')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow border p-6">

    <h2 class="text-lg font-semibold mb-6">
        Add Study Material – {{ $batch->name }}
    </h2>

    <form method="POST"
          action="{{ route('teacher.batches.materials.store', $batch) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Chapter
            </label>
            <select name="chapter_id"
                    class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Select Chapter</option>
                @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}">
                        {{ $chapter->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Title
            </label>
            <input type="text"
                   name="title"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Description
            </label>
            <textarea name="description"
                      class="w-full border rounded px-3 py-2 text-sm"
                      rows="4"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Upload File (PDF)
            </label>
            <input type="file"
                   name="file"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Video Link
            </label>
            <input type="url"
                   name="video_link"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">
                Status
            </label>
            <select name="status"
                    class="w-full border rounded px-3 py-2 text-sm">
                <option value="active">Active</option>
                <option value="in_active">Inactive</option>
            </select>
        </div>

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Save Material
        </button>

    </form>

</div>

@endsection
