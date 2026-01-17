@extends('layouts.admin')
@section('content')
@can('batch_student_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.batch-students.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.batchStudent.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BatchStudent', 'route' => 'admin.batch-students.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.batchStudent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BatchStudent">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.batch') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.student') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.joining_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.discount') }}
                        </th>
                        <th>
                            {{ trans('cruds.batchStudent.fields.remarks') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batchStudents as $key => $batchStudent)
                        <tr data-entry-id="{{ $batchStudent->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $batchStudent->id ?? '' }}
                            </td>
                            <td>
                                {{ $batchStudent->batch->name ?? '' }}
                            </td>
                            <td>
                                {{ $batchStudent->student->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $batchStudent->joining_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\BatchStudent::STATUS_SELECT[$batchStudent->status] ?? '' }}
                            </td>
                            <td>
                                {{ $batchStudent->discount ?? '' }}
                            </td>
                            <td>
                                {{ $batchStudent->remarks ?? '' }}
                            </td>
                            <td>
                                @can('batch_student_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.batch-students.show', $batchStudent->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('batch_student_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.batch-students.edit', $batchStudent->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('batch_student_delete')
                                    <form action="{{ route('admin.batch-students.destroy', $batchStudent->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('batch_student_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.batch-students.massDestroy') }}",
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
  let table = $('.datatable-BatchStudent:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection