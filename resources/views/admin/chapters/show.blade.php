@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.chapter.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.chapters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.chapter.fields.id') }}
                        </th>
                        <td>
                            {{ $chapter->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chapter.fields.subject') }}
                        </th>
                        <td>
                            {{ $chapter->subject->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chapter.fields.name') }}
                        </th>
                        <td>
                            {{ $chapter->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chapter.fields.class_level') }}
                        </th>
                        <td>
                            {{ $chapter->class_level }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.chapter.fields.order_no') }}
                        </th>
                        <td>
                            {{ $chapter->order_no }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.chapters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection