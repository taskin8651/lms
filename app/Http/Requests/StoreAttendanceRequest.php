<?php

namespace App\Http\Requests;

use App\Models\Attendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('attendance_create');
    }

    public function rules()
    {
        return [
            'attendance_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'punch_in_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'punch_out_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'punch_in_lat' => [
                'string',
                'nullable',
            ],
            'punch_in_lng' => [
                'string',
                'nullable',
            ],
            'punch_out_lat' => [
                'string',
                'nullable',
            ],
            'punch_out_lng' => [
                'string',
                'nullable',
            ],
        ];
    }
}
