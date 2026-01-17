<?php

namespace App\Http\Requests;

use App\Models\StudyMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudyMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('study_material_edit');
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
