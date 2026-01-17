@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.liveClass.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.live-classes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.id') }}
                        </th>
                        <td>
                            {{ $liveClass->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.batch') }}
                        </th>
                        <td>
                            {{ $liveClass->batch->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.teacher') }}
                        </th>
                        <td>
                            {{ $liveClass->teacher->mobile ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.class_date') }}
                        </th>
                        <td>
                            {{ $liveClass->class_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.start_time') }}
                        </th>
                        <td>
                            {{ $liveClass->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.end_time') }}
                        </th>
                        <td>
                            {{ $liveClass->end_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.class_type') }}
                        </th>
                        <td>
                            {{ App\Models\LiveClass::CLASS_TYPE_SELECT[$liveClass->class_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.meeting_link') }}
                        </th>
                        <td>
                            {{ $liveClass->meeting_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.topic') }}
                        </th>
                        <td>
                            {{ $liveClass->topic }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.description') }}
                        </th>
                        <td>
                            {{ $liveClass->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.recording_link') }}
                        </th>
                        <td>
                            {{ $liveClass->recording_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\LiveClass::STATUS_SELECT[$liveClass->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.remark') }}
                        </th>
                        <td>
                            {{ $liveClass->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.liveClass.fields.photo') }}
                        </th>
                        <td>
                            @if($liveClass->photo)
                                <a href="{{ $liveClass->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $liveClass->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.live-classes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection