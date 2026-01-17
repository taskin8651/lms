@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.batch.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.batches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.id') }}
                        </th>
                        <td>
                            {{ $batch->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.name') }}
                        </th>
                        <td>
                            {{ $batch->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.class_level') }}
                        </th>
                        <td>
                            {{ $batch->class_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.subject') }}
                        </th>
                        <td>
                            {{ $batch->subject->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.teacher') }}
                        </th>
                        <td>
                            {{ $batch->teacher->mobile ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.academic_session') }}
                        </th>
                        <td>
                            {{ $batch->academic_session->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.timing') }}
                        </th>
                        <td>
                            {{ $batch->timing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.fees_amount') }}
                        </th>
                        <td>
                            {{ $batch->fees_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.batch.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Batch::STATUS_SELECT[$batch->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.batches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection