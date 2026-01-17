<?php

namespace App\Http\Requests;

use App\Models\LiveClass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLiveClassRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('live_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:live_classes,id',
        ];
    }
}
