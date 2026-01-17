@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studyMaterial.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.study-materials.update", [$studyMaterial->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="chapter_id">{{ trans('cruds.studyMaterial.fields.chapter') }}</label>
                <select class="form-control select2 {{ $errors->has('chapter') ? 'is-invalid' : '' }}" name="chapter_id" id="chapter_id">
                    @foreach($chapters as $id => $entry)
                        <option value="{{ $id }}" {{ (old('chapter_id') ? old('chapter_id') : $studyMaterial->chapter->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('chapter'))
                    <div class="invalid-feedback">
                        {{ $errors->first('chapter') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.chapter_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.studyMaterial.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $studyMaterial->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.studyMaterial.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.studyMaterial.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $studyMaterial->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.studyMaterial.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudyMaterial::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $studyMaterial->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="video_link">{{ trans('cruds.studyMaterial.fields.video_link') }}</label>
                <textarea class="form-control {{ $errors->has('video_link') ? 'is-invalid' : '' }}" name="video_link" id="video_link">{{ old('video_link', $studyMaterial->video_link) }}</textarea>
                @if($errors->has('video_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('video_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studyMaterial.fields.video_link_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.study-materials.storeMedia') }}',
    maxFilesize: 200, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 200
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($studyMaterial) && $studyMaterial->file)
      var file = {!! json_encode($studyMaterial->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection