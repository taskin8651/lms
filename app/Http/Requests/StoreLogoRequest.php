<?php

namespace App\Http\Requests;

use App\Models\Logo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLogoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('logo_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
