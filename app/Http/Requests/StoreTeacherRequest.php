<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('teacher_create');
    }

    public function rules()
    {
        return [
            'mobile' => [
                'string',
                'nullable',
            ],
            'subject' => [
                'string',
                'nullable',
            ],
            'experience' => [
                'string',
                'nullable',
            ],
            'joining_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'salary' => [
                'string',
                'nullable',
            ],
            'document' => [
                'array',
            ],
        ];
    }
}
