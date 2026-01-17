@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.enquiry.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.enquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.id') }}
                        </th>
                        <td>
                            {{ $enquiry->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.name') }}
                        </th>
                        <td>
                            {{ $enquiry->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.email') }}
                        </th>
                        <td>
                            {{ $enquiry->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.number') }}
                        </th>
                        <td>
                            {{ $enquiry->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.full_address') }}
                        </th>
                        <td>
                            {{ $enquiry->full_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.enquiry.fields.message') }}
                        </th>
                        <td>
                            {{ $enquiry->message }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.enquiries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection