<?php

namespace App\Http\Requests;

use App\Models\ContactDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreContactDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contact_detail_create');
    }

    public function rules()
    {
        return [
            'email' => [
                'string',
                'nullable',
            ],
            'number' => [
                'string',
                'nullable',
            ],
            'time' => [
                'string',
                'nullable',
            ],
        ];
    }
}
