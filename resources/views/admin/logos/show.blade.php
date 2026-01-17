@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.logo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.logo.fields.id') }}
                        </th>
                        <td>
                            {{ $logo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logo.fields.name') }}
                        </th>
                        <td>
                            {{ $logo->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logo.fields.image_1') }}
                        </th>
                        <td>
                            @if($logo->image_1)
                                <a href="{{ $logo->image_1->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $logo->image_1->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logo.fields.description') }}
                        </th>
                        <td>
                            {!! $logo->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.logos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection