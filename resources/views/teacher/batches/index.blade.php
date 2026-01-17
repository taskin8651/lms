@extends('teacher.layout')

@section('page-title', 'My Batches')

@section('content')

<!-- ================= HEADER + FILTER ================= -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            My Batches
        </h2>
        <p class="text-sm text-gray-500">
            All batches assigned to you
        </p>
    </div>

    <!-- FILTERS (RIGHT SIDE) -->
    <div class="flex space-x-3 mt-3 md:mt-0">
        <input
            id="batchSearch"
            type="text"
            placeholder="Search batch / subject"
            class="border rounded-lg px-3 py-2 text-sm w-52 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <select
            id="statusFilter"
            class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="in_active">Inactive</option>
        </select>
    </div>
</div>

<!-- ================= BATCH CARDS ================= -->
<div id="batchGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

@forelse($batches as $batch)
<div
    class="batch-card bg-white border border-gray-200 rounded-2xl shadow-sm
           hover:shadow-xl hover:-translate-y-1 transition-all duration-200"
    data-name="{{ strtolower($batch->name) }}"
    data-subject="{{ strtolower($batch->subject->name ?? '') }}"
    data-status="{{ $batch->status }}"
>

    <div class="p-6">

        <!-- ================= HEADER ================= -->
        <div class="flex items-start gap-4">

            <!-- SUBJECT IMAGE -->
            <div class="w-18 h-18 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 ring-1 ring-gray-200">
                @if($batch->subject && $batch->subject->image)
                    <img
                        src="{{ $batch->subject->image->preview }}"
                        class="w-full h-full object-cover"
                        alt="Subject">
                @else
                    <div class="w-full h-full flex items-center justify-center text-sm font-bold text-gray-500">
                        {{ strtoupper(substr($batch->subject->name ?? 'S', 0, 2)) }}
                    </div>
                @endif
            </div>

            <!-- TITLE -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800 leading-snug">
                    {{ $batch->name }}
                </h3>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $batch->class_level->name ?? '-' }} • {{ $batch->subject->name ?? '-' }}
                </p>
            </div>
        </div>

        <!-- ================= INFO ================= -->
        <div class="mt-5 grid grid-cols-2 gap-4 text-sm text-gray-600">

            <div>
                <p class="text-xs text-gray-400 mb-0.5">Timing</p>
                <p class="font-medium text-gray-800">
                    {{ $batch->timing ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-0.5">Students</p>
                <p class="font-semibold text-blue-600 text-lg">
                    {{ $batch->students_count }}
                </p>
            </div>

        </div>

       <!-- ================= ACTIONS ================= -->
<div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">

    <!-- Students -->
    <a href="{{ route('teacher.batches.students', $batch->id) }}"
       class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg
              border border-gray-200 hover:bg-gray-50 transition">
        👥 Students
    </a>

    <!-- Live Classes -->
    <a href="{{ route('teacher.batches.live-classes', $batch->id) }}"
       class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg
              border border-blue-200 text-blue-700 hover:bg-blue-50 transition">
        🎥 Live
    </a>

    <!-- Today Attendance -->
    <a href="{{ route('teacher.batches.attendance.today', $batch->id) }}"
       class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg
              border border-green-200 text-green-700 hover:bg-green-50 transition">
        📋 Today
    </a>

    <!-- Tests / Practice -->
    <a href="{{ route('teacher.batches.tests', $batch->id) }}"
       class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg
              border border-purple-200 text-purple-700 hover:bg-purple-50 transition font-medium">
        🧪 Tests
    </a>

    <a href="{{ route('teacher.batches.tests.results', $batch) }}"
   class="flex items-center justify-center gap-1 px-3 py-2 rounded-lg
          border border-purple-200 text-purple-700 hover:bg-purple-50 transition">
    📊 Results
</a>

</div>


        <!-- ================= FOOTER ================= -->
        <div class="mt-5 flex items-center justify-between">

            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                {{ $batch->status === 'active'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst(str_replace('_',' ', $batch->status)) }}
            </span>

            <span class="text-xs text-gray-400">
                Batch ID: {{ $batch->id }}
            </span>

        </div>

    </div>
</div>
@empty
    <div class="col-span-full text-center text-gray-500 py-20">
        <p class="text-lg font-medium">No batches assigned</p>
        <p class="text-sm text-gray-400 mt-1">
            Once admin assigns a batch, it will appear here.
        </p>
    </div>
@endforelse

</div>


<!-- ================= JS FILTER ================= -->
<script>
    const batchSearch = document.getElementById('batchSearch');
    const statusFilter = document.getElementById('statusFilter');
    const batchCards = document.querySelectorAll('.batch-card');

    function filterBatches() {
        const search = batchSearch.value.toLowerCase();
        const status = statusFilter.value;

        batchCards.forEach(card => {
            const name = card.dataset.name;
            const subject = card.dataset.subject;
            const cardStatus = card.dataset.status;

            const matchSearch =
                name.includes(search) || subject.includes(search);

            const matchStatus =
                status === '' || status === cardStatus;

            card.style.display =
                matchSearch && matchStatus ? 'block' : 'none';
        });
    }

    batchSearch.addEventListener('input', filterBatches);
    statusFilter.addEventListener('change', filterBatches);
</script>

@endsection
