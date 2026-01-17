<?php

namespace App\Http\Requests;

use App\Models\LiveClass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLiveClassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('live_class_create');
    }

    public function rules()
    {
        return [
            'class_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'end_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'meeting_link' => [
                'string',
                'nullable',
            ],
            'topic' => [
                'string',
                'nullable',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
