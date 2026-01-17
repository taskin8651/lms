@extends('layouts.admin')
@section('content')
@can('teacher_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.teachers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.teacher.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Teacher', 'route' => 'admin.teachers.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.teacher.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Teacher">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.subject') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.experience') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.joining_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.salary') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.profile') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.document') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $key => $teacher)
                        <tr data-entry-id="{{ $teacher->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $teacher->id ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->subject ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->experience ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->joining_date ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->salary ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Teacher::STATUS_SELECT[$teacher->status] ?? '' }}
                            </td>
                            <td>
                                @if($teacher->profile)
                                    <a href="{{ $teacher->profile->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $teacher->profile->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($teacher->document as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('teacher_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.teachers.show', $teacher->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('teacher_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.teachers.edit', $teacher->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('teacher_delete')
                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('teacher_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.teachers.massDestroy') }}",
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
  let table = $('.datatable-Teacher:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection