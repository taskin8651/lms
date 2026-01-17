@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contactDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contact-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $contactDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.address') }}
                        </th>
                        <td>
                            {{ $contactDetail->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.email') }}
                        </th>
                        <td>
                            {{ $contactDetail->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.number') }}
                        </th>
                        <td>
                            {{ $contactDetail->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.url') }}
                        </th>
                        <td>
                            {{ $contactDetail->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contactDetail.fields.time') }}
                        </th>
                        <td>
                            {{ $contactDetail->time }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contact-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection