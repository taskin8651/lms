@extends('layouts.admin')
@section('content')
@can('academic_session_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.academic-sessions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.academicSession.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'AcademicSession', 'route' => 'admin.academic-sessions.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.academicSession.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AcademicSession">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.academicSession.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.academicSession.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.academicSession.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.academicSession.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.academicSession.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($academicSessions as $key => $academicSession)
                        <tr data-entry-id="{{ $academicSession->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $academicSession->id ?? '' }}
                            </td>
                            <td>
                                {{ $academicSession->name ?? '' }}
                            </td>
                            <td>
                                {{ $academicSession->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $academicSession->end_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\AcademicSession::STATUS_SELECT[$academicSession->status] ?? '' }}
                            </td>
                            <td>
                                @can('academic_session_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.academic-sessions.show', $academicSession->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('academic_session_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.academic-sessions.edit', $academicSession->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('academic_session_delete')
                                    <form action="{{ route('admin.academic-sessions.destroy', $academicSession->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('academic_session_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.academic-sessions.massDestroy') }}",
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
  let table = $('.datatable-AcademicSession:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection