@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.attendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.id') }}
                        </th>
                        <td>
                            {{ $attendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.batch_student') }}
                        </th>
                        <td>
                            {{ $attendance->batch_student->joining_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.attendance_date') }}
                        </th>
                        <td>
                            {{ $attendance->attendance_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_time') }}
                        </th>
                        <td>
                            {{ $attendance->punch_in_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_time') }}
                        </th>
                        <td>
                            {{ $attendance->punch_out_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Attendance::STATUS_SELECT[$attendance->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_image') }}
                        </th>
                        <td>
                            @if($attendance->punch_in_image)
                                <a href="{{ $attendance->punch_in_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $attendance->punch_in_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_image') }}
                        </th>
                        <td>
                            @if($attendance->punch_out_image)
                                <a href="{{ $attendance->punch_out_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $attendance->punch_out_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_lat') }}
                        </th>
                        <td>
                            {{ $attendance->punch_in_lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_lng') }}
                        </th>
                        <td>
                            {{ $attendance->punch_in_lng }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_location') }}
                        </th>
                        <td>
                            {{ $attendance->punch_in_location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_lat') }}
                        </th>
                        <td>
                            {{ $attendance->punch_out_lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_lng') }}
                        </th>
                        <td>
                            {{ $attendance->punch_out_lng }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_loc') }}
                        </th>
                        <td>
                            {{ $attendance->punch_out_loc }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.marked_by') }}
                        </th>
                        <td>
                            {{ $attendance->marked_by->mobile ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendance.fields.remarks') }}
                        </th>
                        <td>
                            {{ $attendance->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection