<?php

namespace App\Http\Requests;

use App\Models\Question;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_create');
    }

    public function rules()
    {
        return [
            'option_a' => [
                'string',
                'nullable',
            ],
            'option_b' => [
                'string',
                'nullable',
            ],
            'option_c' => [
                'string',
                'nullable',
            ],
            'option_d' => [
                'string',
                'nullable',
            ],
            'correct_option' => [
                'string',
                'nullable',
            ],
            'marks' => [
                'string',
                'nullable',
            ],
            'negative_marks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
