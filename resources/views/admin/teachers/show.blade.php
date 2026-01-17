@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.teacher.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teachers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.id') }}
                        </th>
                        <td>
                            {{ $teacher->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.user') }}
                        </th>
                        <td>
                            {{ $teacher->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.mobile') }}
                        </th>
                        <td>
                            {{ $teacher->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.subject') }}
                        </th>
                        <td>
                            {{ $teacher->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.experience') }}
                        </th>
                        <td>
                            {{ $teacher->experience }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.joining_date') }}
                        </th>
                        <td>
                            {{ $teacher->joining_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.salary') }}
                        </th>
                        <td>
                            {{ $teacher->salary }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Teacher::STATUS_SELECT[$teacher->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.profile') }}
                        </th>
                        <td>
                            @if($teacher->profile)
                                <a href="{{ $teacher->profile->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $teacher->profile->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.document') }}
                        </th>
                        <td>
                            @foreach($teacher->document as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teachers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection