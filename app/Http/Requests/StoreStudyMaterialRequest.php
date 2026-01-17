<?php

namespace App\Http\Requests;

use App\Models\StudyMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudyMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('study_material_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
