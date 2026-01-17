@extends('teacher.layout')

@section('page-title', 'Schedule Live Class')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        Schedule Live Class
    </h2>
    <p class="text-sm text-gray-500">
        Batch: {{ $batch->name }}
    </p>
</div>

<!-- ================= FORM ================= -->
<form
    method="POST"
    action="{{ route('teacher.batches.live-classes.store', $batch->id) }}"
    class="max-w-3xl bg-white border rounded-2xl p-6 shadow-sm space-y-6"
>
@csrf

<!-- TOP GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- Class Date -->
    <div>
        <label class="block text-sm font-medium mb-1">Class Date *</label>
        <input
            type="date"
            name="class_date"
            value="{{ old('class_date') }}"
            class="w-full border rounded-lg px-3 py-2 text-sm"
            required>
    </div>

    <!-- Topic -->
    <div>
        <label class="block text-sm font-medium mb-1">Topic *</label>
        <input
            type="text"
            name="topic"
            value="{{ old('topic') }}"
            placeholder="e.g. Real Numbers – Introduction"
            class="w-full border rounded-lg px-3 py-2 text-sm"
            required>
    </div>

</div>

<!-- TIME -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-medium mb-1">Start Time *</label>
        <input
            type="time"
            name="start_time"
            value="{{ old('start_time') }}"
            class="w-full border rounded-lg px-3 py-2 text-sm"
            required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">End Time *</label>
        <input
            type="time"
            name="end_time"
            value="{{ old('end_time') }}"
            class="w-full border rounded-lg px-3 py-2 text-sm"
            required>
    </div>

</div>

<!-- CLASS TYPE -->
<div>
    <label class="block text-sm font-medium mb-1">Class Type *</label>
    <select
        name="class_type"
        id="class_type"
        class="w-full border rounded-lg px-3 py-2 text-sm"
        onchange="toggleLinkField()"
        required
    >
        <option value="">Select Type</option>
        <option value="custom">Custom</option>
        <option value="google_meet">Google Meet</option>
        <option value="youtube_live">YouTube Live</option>
    </select>
</div>

<!-- MEETING LINK -->
<div id="meetingLinkBox" class="hidden">
    <label class="block text-sm font-medium mb-1">
        Meeting / Stream Link
    </label>
    <input
        type="url"
        name="meeting_link"
        value="{{ old('meeting_link') }}"
        placeholder="https://meet.google.com/..."
        class="w-full border rounded-lg px-3 py-2 text-sm">
</div>

<!-- DESCRIPTION -->
<div>
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea
        name="description"
        rows="3"
        class="w-full border rounded-lg px-3 py-2 text-sm"
        placeholder="Class details / instructions">{{ old('description') }}</textarea>
</div>

<!-- RECORDING -->
<div>
    <label class="block text-sm font-medium mb-1">Recording Link (optional)</label>
    <input
        type="url"
        name="recording_link"
        value="{{ old('recording_link') }}"
        placeholder="https://youtube.com/..."
        class="w-full border rounded-lg px-3 py-2 text-sm">
</div>

<!-- ACTIONS -->
<div class="flex items-center gap-4 pt-4">
    <button
        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
        Save Live Class
    </button>

    <a href="{{ route('teacher.batches.live-classes', $batch->id) }}"
       class="text-sm text-gray-600 hover:underline">
        Cancel
    </a>
</div>

</form>

<!-- ================= SCRIPT ================= -->
<script>
function toggleLinkField() {
    const type = document.getElementById('class_type').value;
    const box = document.getElementById('meetingLinkBox');

    if (type === 'google_meet' || type === 'youtube_live') {
        box.classList.remove('hidden');
    } else {
        box.classList.add('hidden');
    }
}
</script>

@endsection
