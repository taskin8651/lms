<?php

namespace App\Http\Requests;

use App\Models\ClassLevel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClassLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('class_level_create');
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
