<?php

namespace App\Http\Requests;

use App\Models\ClassLevel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyClassLevelRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('class_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:class_levels,id',
        ];
    }
}
