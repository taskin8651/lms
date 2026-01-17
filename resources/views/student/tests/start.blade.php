@extends('student.layout')

@section('page-title', 'Attempt Test')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- ================= TOP BAR ================= --}}
    <div class="bg-orange-500 text-white px-6 py-3 flex justify-between items-center rounded-t-xl">
        <h2 class="font-semibold">
            {{ $test->title }}
        </h2>
        <div class="font-bold">
            ⏱ Time Left: <span id="timer">--:--</span>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 border border-t-0 rounded-b-xl">

        {{-- ================= QUESTION AREA ================= --}}
        <form id="testForm"
              method="POST"
              action="{{ route('student.tests.submit', $test) }}"
              class="col-span-8 p-6">

            @csrf
            <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

            @foreach($questions as $index => $question)
                <div class="question-slide {{ $index !== 0 ? 'hidden' : '' }}"
                     data-index="{{ $index }}"
                     data-question="{{ $question->id }}">

                    <p class="font-semibold mb-3">
                        Question {{ $index + 1 }}
                    </p>

                    <p class="mb-4 text-gray-800">
                        {{ $question->question }}
                    </p>

                    <div class="space-y-3 text-sm">
                        @foreach(['a','b','c','d'] as $opt)
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio"
                                       class="answer-radio accent-blue-600"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $opt }}">
                                {{ $question->{'option_'.$opt} }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="button"
                        onclick="saveAndNext()"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                    Save & Next
                </button>

                <button type="button"
                        onclick="markReviewNext()"
                        class="bg-purple-600 text-white px-4 py-2 rounded">
                    Mark for Review & Next
                </button>

                <button type="button"
                        onclick="clearResponse()"
                        class="bg-gray-300 px-4 py-2 rounded">
                    Clear Response
                </button>
            </div>

            <div class="mt-6 text-right">
                <button onclick="return confirm('Submit test now?')"
                        class="bg-red-600 text-white px-6 py-2 rounded">
                    Submit Test
                </button>
            </div>

        </form>

        {{-- ================= QUESTION PALETTE ================= --}}
        <aside class="col-span-4 border-l p-4 bg-gray-50">

            <h3 class="font-semibold mb-3">Question Palette</h3>

            <div class="grid grid-cols-6 gap-2 mb-4">
                @foreach($questions as $i => $q)
                    <button type="button"
                            onclick="goTo({{ $i }})"
                            id="palette-{{ $i }}"
                            class="w-10 h-10 rounded bg-gray-300 text-sm font-semibold">
                        {{ $i + 1 }}
                    </button>
                @endforeach
            </div>

            {{-- LEGEND --}}
            <div class="text-xs space-y-1">
                <p><span class="inline-block w-3 h-3 bg-gray-300"></span> Not Visited</p>
                <p><span class="inline-block w-3 h-3 bg-red-500"></span> Not Answered</p>
                <p><span class="inline-block w-3 h-3 bg-green-500"></span> Answered</p>
                <p><span class="inline-block w-3 h-3 bg-purple-500"></span> Marked for Review</p>
            </div>

        </aside>

    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
    let slides = document.querySelectorAll('.question-slide');
    let current = 0;

    function show(index) {
        slides.forEach(s => s.classList.add('hidden'));
        slides[index].classList.remove('hidden');
        current = index;
    }

    function goTo(i) {
        show(i);
    }

    function palette(i) {
        return document.getElementById('palette-' + i);
    }

    function setPalette(i, color) {
        let base = 'w-10 h-10 rounded text-sm font-semibold ';
        if (color === 'green') palette(i).className = base + 'bg-green-500 text-white';
        if (color === 'red') palette(i).className = base + 'bg-red-500 text-white';
        if (color === 'purple') palette(i).className = base + 'bg-purple-500 text-white';
    }

    function isAnswered() {
        return slides[current].querySelector('input[type=radio]:checked');
    }

    function saveAndNext() {
        if (isAnswered()) {
            setPalette(current, 'green');
        } else {
            setPalette(current, 'red');
        }
        next();
    }

    function markReviewNext() {
        setPalette(current, 'purple');
        next();
    }

    function clearResponse() {
        slides[current].querySelectorAll('input').forEach(i => i.checked = false);
        setPalette(current, 'red');
    }

    function next() {
        if (current < slides.length - 1) show(current + 1);
    }

    document.querySelectorAll('.answer-radio').forEach(r => {
        r.addEventListener('change', () => {
            setPalette(current, 'green');
        });
    });

    // ================= TIMER =================
    let time = {{ $test->duration }} * 60;
    let timer = document.getElementById('timer');

    setInterval(() => {
        let m = Math.floor(time / 60);
        let s = time % 60;
        timer.innerText = `${m}:${String(s).padStart(2,'0')}`;
        if (--time < 0) document.getElementById('testForm').submit();
    }, 1000);
</script>

@endsection
