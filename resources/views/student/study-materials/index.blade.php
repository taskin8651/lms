@extends('student.layout')

@section('page-title', 'Study Materials')

@section('content')

@php
    $flatMaterials = [];
@endphp

<div class="max-w-6xl mx-auto">

    {{-- ================= HEADER ================= --}}
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            {{ $batch->name }} – Study Materials
        </h2>
        <p class="text-sm text-gray-500">
            Chapter wise notes & video lectures
        </p>
    </div>

    {{-- ================= MATERIAL LIST ================= --}}
    <div id="materialList">

        @forelse($materials as $chapterName => $chapterMaterials)

            <div class="mb-6 bg-white rounded-xl shadow border">

                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-semibold text-gray-800">
                        📘 {{ $chapterName }}
                    </h3>
                </div>

                <div class="divide-y">

                    @foreach($chapterMaterials as $material)

                        @php
                            $flatMaterials[] = [
                                'type'  => $material->file ? 'pdf' : 'video',
                                'url'   => $material->file
                                            ? route('student.material.secure', $material->id)
                                            : $material->video_link,
                                'title' => $material->title
                            ];
                            $index = count($flatMaterials) - 1;
                        @endphp

                        <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">

                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $material->title }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $material->description }}
                                </p>
                            </div>

                            <button
                                onclick="openViewer({{ $index }})"
                                class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Open →
                            </button>

                        </div>

                    @endforeach

                </div>
            </div>

        @empty
            <div class="bg-white rounded-xl border p-8 text-center text-gray-500">
                No study materials available yet.
            </div>
        @endforelse

    </div>


    {{-- ================= FULL SCREEN VIEWER ================= --}}
    <div id="viewerSection" class="hidden">

        <div class="flex justify-between items-center mb-4">

            <button onclick="closeViewer()"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                ← Back
            </button>

            <div class="text-sm text-gray-600 font-medium">
                <span id="materialTitle"></span>
            </div>

        </div>

        <div id="viewerContent"
             class="w-full h-[75vh] bg-white rounded-xl shadow border overflow-hidden">
        </div>

        {{-- PAGINATION --}}
        <div class="flex justify-between mt-4">

            <button onclick="prevMaterial()"
                    class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">
                ← Previous
            </button>

            <button onclick="nextMaterial()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Next →
            </button>

        </div>

    </div>

</div>


<script>

let materials = @json($flatMaterials);
let currentIndex = 0;

function openViewer(index) {
    currentIndex = index;

    document.getElementById('materialList').classList.add('hidden');
    document.getElementById('viewerSection').classList.remove('hidden');

    loadMaterial();
}

function loadMaterial() {

    let material = materials[currentIndex];
    let content = '';

    document.getElementById('materialTitle').innerText =
        `${currentIndex + 1} / ${materials.length} - ${material.title}`;

    if (material.type === 'pdf') {

        content = `
            <iframe src="${material.url}"
                    class="w-full h-full"
                    frameborder="0">
            </iframe>
        `;
    }

    if (material.type === 'video') {

        let url = material.url;

        if (url.includes('watch?v=')) {
            url = url.replace("watch?v=", "embed/");
        }

        content = `
            <iframe src="${url}"
                    class="w-full h-full"
                    frameborder="0"
                    allowfullscreen>
            </iframe>
        `;
    }

    document.getElementById('viewerContent').innerHTML = content;
}

function nextMaterial() {
    if (currentIndex < materials.length - 1) {
        currentIndex++;
        loadMaterial();
    }
}

function prevMaterial() {
    if (currentIndex > 0) {
        currentIndex--;
        loadMaterial();
    }
}

function closeViewer() {
    document.getElementById('viewerSection').classList.add('hidden');
    document.getElementById('materialList').classList.remove('hidden');
    document.getElementById('viewerContent').innerHTML = '';
}

</script>

@endsection
