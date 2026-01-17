<?php

namespace App\Http\Requests;

use App\Models\StudyMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStudyMaterialRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('study_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:study_materials,id',
        ];
    }
}
