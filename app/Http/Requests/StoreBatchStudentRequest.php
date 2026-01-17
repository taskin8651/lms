<?php

namespace App\Http\Requests;

use App\Models\BatchStudent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBatchStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('batch_student_create');
    }

    public function rules()
    {
        return [
            'joining_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'discount' => [
                'string',
                'nullable',
            ],
        ];
    }
}
