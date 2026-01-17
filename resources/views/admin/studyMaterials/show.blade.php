@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.studyMaterial.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.study-materials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.id') }}
                        </th>
                        <td>
                            {{ $studyMaterial->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.chapter') }}
                        </th>
                        <td>
                            {{ $studyMaterial->chapter->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.title') }}
                        </th>
                        <td>
                            {{ $studyMaterial->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.file') }}
                        </th>
                        <td>
                            @if($studyMaterial->file)
                                <a href="{{ $studyMaterial->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.description') }}
                        </th>
                        <td>
                            {{ $studyMaterial->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\StudyMaterial::STATUS_SELECT[$studyMaterial->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studyMaterial.fields.video_link') }}
                        </th>
                        <td>
                            {{ $studyMaterial->video_link }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.study-materials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection