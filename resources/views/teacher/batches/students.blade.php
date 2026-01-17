@extends('teacher.layout')

@section('page-title', 'Batch Students')

@section('content')

<!-- ================= HEADER ================= -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-5">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $batch->name }}
        </h2>
        <p class="text-sm text-gray-500">
            Class: {{ $batch->class_level->name ?? '-' }} |
            Subject: {{ $batch->subject->name ?? '-' }}
        </p>
    </div>

    <!-- FILTER (RIGHT SIDE) -->
    <div class="flex space-x-3 mt-3 md:mt-0">
        <input
            id="searchInput"
            type="text"
            placeholder="Search name / mobile"
            class="border rounded-lg px-3 py-2 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <select
            id="statusFilter"
            class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="left">Left</option>
            <option value="complete">Completed</option>
        </select>
    </div>
</div>
<!-- ================= STUDENT CARDS ================= -->
<div id="studentsGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

@forelse($students as $row)
<div
    class="student-card bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition duration-200"
    data-name="{{ strtolower($row->student->user->name ?? '') }}"
    data-mobile="{{ $row->student->mobile ?? '' }}"
    data-status="{{ $row->status }}"
>

    <!-- CARD BODY -->
    <div class="p-5">

        <!-- TOP SECTION -->
        <div class="flex items-center gap-4">

            <!-- PROFILE IMAGE -->
            <div class="relative">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 ring-2 ring-gray-200">
                    @if($row->student->profile->first())
                        <img
                            src="{{ $row->student->profile->first()->preview }}"
                            class="w-full h-full object-cover"
                            alt="Student">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xl font-bold text-gray-500">
                            {{ strtoupper(substr($row->student->user->name ?? 'S', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <!-- STATUS DOT -->
                <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full border-2 border-white
                    {{ $row->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                </span>
            </div>

            <!-- NAME -->
            <div class="flex-1">
                <p class="text-base font-semibold text-gray-800 leading-tight">
                    {{ $row->student->user->name ?? '-' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Student ID: {{ $row->student->id }}
                </p>
            </div>
        </div>

        <!-- DIVIDER -->
        <hr class="my-4">

        <!-- DETAILS -->
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex justify-between">
                <span class="text-gray-500">Mobile</span>
                <span class="font-medium">{{ $row->student->mobile ?? '-' }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Joined</span>
                <span class="font-medium">{{ $row->joining_date }}</span>
            </div>
        </div>

        <!-- STATUS BADGE -->
        <div class="mt-4">
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                {{ $row->status === 'active'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($row->status) }}
            </span>
        </div>

    </div>
</div>
@empty
    <div class="col-span-full text-center text-gray-500 py-16">
        No students found.
    </div>
@endforelse

</div>


<!-- ================= JS FILTER ================= -->
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const cards = document.querySelectorAll('.student-card');

    function filterStudents() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        cards.forEach(card => {
            const name = card.dataset.name;
            const mobile = card.dataset.mobile;
            const cardStatus = card.dataset.status;

            const matchSearch =
                name.includes(search) || mobile.includes(search);

            const matchStatus =
                status === '' || status === cardStatus;

            card.style.display =
                matchSearch && matchStatus ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterStudents);
    statusFilter.addEventListener('change', filterStudents);
</script>

@endsection
