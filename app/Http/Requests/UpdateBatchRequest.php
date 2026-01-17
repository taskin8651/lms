<?php

namespace App\Http\Requests;

use App\Models\Batch;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBatchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('batch_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'timing' => [
                'string',
                'nullable',
            ],
            'fees_amount' => [
                'string',
                'nullable',
            ],
        ];
    }
}
