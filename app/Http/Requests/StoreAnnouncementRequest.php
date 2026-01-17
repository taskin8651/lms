<?php

namespace App\Http\Requests;

use App\Models\Announcement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('announcement_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'publish_date' => [
                'string',
                'nullable',
            ],
            'expire_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
