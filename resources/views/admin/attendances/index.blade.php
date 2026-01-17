@extends('layouts.admin')
@section('content')
@can('attendance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.attendances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.attendance.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Attendance', 'route' => 'admin.attendances.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.attendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Attendance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.batch_student') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.attendance_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_lng') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_in_location') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_lng') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.punch_out_loc') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.marked_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendance.fields.remarks') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $key => $attendance)
                        <tr data-entry-id="{{ $attendance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $attendance->id ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->batch_student->joining_date ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->attendance_date ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_in_time ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_out_time ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Attendance::STATUS_SELECT[$attendance->status] ?? '' }}
                            </td>
                            <td>
                                @if($attendance->punch_in_image)
                                    <a href="{{ $attendance->punch_in_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $attendance->punch_in_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($attendance->punch_out_image)
                                    <a href="{{ $attendance->punch_out_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $attendance->punch_out_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $attendance->punch_in_lat ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_in_lng ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_in_location ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_out_lat ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_out_lng ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->punch_out_loc ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->marked_by->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $attendance->remarks ?? '' }}
                            </td>
                            <td>
                                @can('attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.attendances.show', $attendance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('attendance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.attendances.edit', $attendance->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('attendance_delete')
                                    <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.attendances.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Attendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection