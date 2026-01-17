@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crousel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crousels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.id') }}
                        </th>
                        <td>
                            {{ $crousel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.title') }}
                        </th>
                        <td>
                            {{ $crousel->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.upload_image') }}
                        </th>
                        <td>
                            @if($crousel->upload_image)
                                <a href="{{ $crousel->upload_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $crousel->upload_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.description') }}
                        </th>
                        <td>
                            {{ $crousel->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.link') }}
                        </th>
                        <td>
                            {{ $crousel->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crousel.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Crousel::STATUS_SELECT[$crousel->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crousels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection