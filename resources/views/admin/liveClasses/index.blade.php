@extends('layouts.admin')
@section('content')
@can('live_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.live-classes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.liveClass.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'LiveClass', 'route' => 'admin.live-classes.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.liveClass.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LiveClass">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.batch') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.teacher') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.class_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.end_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.class_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.meeting_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.topic') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.recording_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.liveClass.fields.photo') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liveClasses as $key => $liveClass)
                        <tr data-entry-id="{{ $liveClass->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $liveClass->id ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->batch->name ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->teacher->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->class_date ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->end_time ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\LiveClass::CLASS_TYPE_SELECT[$liveClass->class_type] ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->meeting_link ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->topic ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->description ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->recording_link ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\LiveClass::STATUS_SELECT[$liveClass->status] ?? '' }}
                            </td>
                            <td>
                                {{ $liveClass->remark ?? '' }}
                            </td>
                            <td>
                                @if($liveClass->photo)
                                    <a href="{{ $liveClass->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $liveClass->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('live_class_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.live-classes.show', $liveClass->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('live_class_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.live-classes.edit', $liveClass->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('live_class_delete')
                                    <form action="{{ route('admin.live-classes.destroy', $liveClass->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('live_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.live-classes.massDestroy') }}",
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
  let table = $('.datatable-LiveClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection