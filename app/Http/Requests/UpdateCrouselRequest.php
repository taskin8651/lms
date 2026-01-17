<?php

namespace App\Http\Requests;

use App\Models\Crousel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCrouselRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crousel_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'link' => [
                'string',
                'nullable',
            ],
        ];
    }
}
