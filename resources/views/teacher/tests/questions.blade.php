@extends('teacher.layout')

@section('page-title', 'Questions')

@section('content')

<h2 class="text-xl font-semibold text-gray-800 mb-4">
    {{ $test->title }} – Questions
</h2>

<!-- ADD QUESTION -->
<form method="POST"
      action="{{ route('teacher.tests.questions.store', $test) }}"
      class="bg-white border rounded-xl p-6 mb-6 space-y-3">
@csrf

<textarea name="question" placeholder="Question" class="w-full border rounded p-2" required></textarea>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    <input name="option_a" placeholder="Option A" class="border rounded p-2" required>
    <input name="option_b" placeholder="Option B" class="border rounded p-2" required>
    <input name="option_c" placeholder="Option C" class="border rounded p-2" required>
    <input name="option_d" placeholder="Option D" class="border rounded p-2" required>
</div>

<select name="correct_option" class="border rounded p-2">
    <option value="a">Correct Option A</option>
    <option value="b">Correct Option B</option>
    <option value="c">Correct Option C</option>
    <option value="d">Correct Option D</option>
</select>

<div class="grid grid-cols-2 gap-3">
    <input name="marks" placeholder="Marks" class="border rounded p-2" required>
    <input name="negative_marks" placeholder="Negative Marks" class="border rounded p-2">
</div>

<textarea name="explanation" placeholder="Explanation (optional)" class="w-full border rounded p-2"></textarea>

<button class="bg-green-600 text-white px-5 py-2 rounded">
    + Add Question
</button>

</form>

<!-- QUESTION LIST -->
<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Question</th>
                <th class="p-4 text-left">Marks</th>
                <th class="p-4 text-left">Correct</th>
            </tr>
        </thead>

        <tbody>
        @foreach($questions as $q)
            <tr class="border-b">
                <td class="p-4">
                    {{ Str::limit($q->question, 80) }}
                </td>
                <td class="p-4">
                    {{ $q->marks }}
                </td>
                <td class="p-4 font-semibold">
                    {{ strtoupper($q->correct_option) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection
