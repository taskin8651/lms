@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.classLevel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.class-levels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.classLevel.fields.id') }}
                        </th>
                        <td>
                            {{ $classLevel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classLevel.fields.name') }}
                        </th>
                        <td>
                            {{ $classLevel->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classLevel.fields.description') }}
                        </th>
                        <td>
                            {!! $classLevel->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.classLevel.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ClassLevel::STATUS_SELECT[$classLevel->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.class-levels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection