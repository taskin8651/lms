<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'mobile' => [
                'string',
                'nullable',
            ],
            'class' => [
                'string',
                'nullable',
            ],
            'parent_name' => [
                'string',
                'nullable',
            ],
            'parent_mobile' => [
                'string',
                'nullable',
            ],
            'admission_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'profile' => [
                'array',
            ],
            'document' => [
                'array',
            ],
        ];
    }
}
