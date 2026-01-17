@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subject.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subjects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.id') }}
                        </th>
                        <td>
                            {{ $subject->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.class_level') }}
                        </th>
                        <td>
                            {{ $subject->class_level->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.name') }}
                        </th>
                        <td>
                            {{ $subject->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Subject::STATUS_SELECT[$subject->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.image') }}
                        </th>
                        <td>
                            @if($subject->image)
                                <a href="{{ $subject->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $subject->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subjects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection