@extends('layouts.admin')
@section('content')
@can('chapter_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.chapters.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.chapter.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Chapter', 'route' => 'admin.chapters.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.chapter.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Chapter">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.chapter.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.chapter.fields.subject') }}
                        </th>
                        <th>
                            {{ trans('cruds.chapter.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.chapter.fields.class_level') }}
                        </th>
                        <th>
                            {{ trans('cruds.chapter.fields.order_no') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chapters as $key => $chapter)
                        <tr data-entry-id="{{ $chapter->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $chapter->id ?? '' }}
                            </td>
                            <td>
                                {{ $chapter->subject->name ?? '' }}
                            </td>
                            <td>
                                {{ $chapter->name ?? '' }}
                            </td>
                            <td>
                                {{ $chapter->class_level ?? '' }}
                            </td>
                            <td>
                                {{ $chapter->order_no ?? '' }}
                            </td>
                            <td>
                                @can('chapter_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.chapters.show', $chapter->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('chapter_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.chapters.edit', $chapter->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('chapter_delete')
                                    <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('chapter_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.chapters.massDestroy') }}",
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
  let table = $('.datatable-Chapter:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection