@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.batchStudent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.batch-students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.id') }}
                        </th>
                        <td>
                            {{ $batchStudent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.batch') }}
                        </th>
                        <td>
                            {{ $batchStudent->batch->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.student') }}
                        </th>
                        <td>
                            {{ $batchStudent->student->mobile ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.joining_date') }}
                        </th>
                        <td>
                            {{ $batchStudent->joining_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\BatchStudent::STATUS_SELECT[$batchStudent->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.discount') }}
                        </th>
                        <td>
                            {{ $batchStudent->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batchStudent.fields.remarks') }}
                        </th>
                        <td>
                            {{ $batchStudent->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.batch-students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection