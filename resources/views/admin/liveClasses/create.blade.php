@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.liveClass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.live-classes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="batch_id">{{ trans('cruds.liveClass.fields.batch') }}</label>
                <select class="form-control select2 {{ $errors->has('batch') ? 'is-invalid' : '' }}" name="batch_id" id="batch_id">
                    @foreach($batches as $id => $entry)
                        <option value="{{ $id }}" {{ old('batch_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('batch'))
                    <div class="invalid-feedback">
                        {{ $errors->first('batch') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.batch_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="teacher_id">{{ trans('cruds.liveClass.fields.teacher') }}</label>
                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id">
                    @foreach($teachers as $id => $entry)
                        <option value="{{ $id }}" {{ old('teacher_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('teacher'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teacher') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.teacher_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_date">{{ trans('cruds.liveClass.fields.class_date') }}</label>
                <input class="form-control date {{ $errors->has('class_date') ? 'is-invalid' : '' }}" type="text" name="class_date" id="class_date" value="{{ old('class_date') }}">
                @if($errors->has('class_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.class_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_time">{{ trans('cruds.liveClass.fields.start_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}">
                @if($errors->has('start_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.start_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_time">{{ trans('cruds.liveClass.fields.end_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}">
                @if($errors->has('end_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.end_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.liveClass.fields.class_type') }}</label>
                <select class="form-control {{ $errors->has('class_type') ? 'is-invalid' : '' }}" name="class_type" id="class_type">
                    <option value disabled {{ old('class_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\LiveClass::CLASS_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('class_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('class_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.class_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="meeting_link">{{ trans('cruds.liveClass.fields.meeting_link') }}</label>
                <input class="form-control {{ $errors->has('meeting_link') ? 'is-invalid' : '' }}" type="text" name="meeting_link" id="meeting_link" value="{{ old('meeting_link', '') }}">
                @if($errors->has('meeting_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meeting_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.meeting_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="topic">{{ trans('cruds.liveClass.fields.topic') }}</label>
                <input class="form-control {{ $errors->has('topic') ? 'is-invalid' : '' }}" type="text" name="topic" id="topic" value="{{ old('topic', '') }}">
                @if($errors->has('topic'))
                    <div class="invalid-feedback">
                        {{ $errors->first('topic') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.topic_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.liveClass.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recording_link">{{ trans('cruds.liveClass.fields.recording_link') }}</label>
                <textarea class="form-control {{ $errors->has('recording_link') ? 'is-invalid' : '' }}" name="recording_link" id="recording_link">{{ old('recording_link') }}</textarea>
                @if($errors->has('recording_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('recording_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.recording_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.liveClass.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\LiveClass::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.liveClass.fields.remark') }}</label>
                <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{{ old('remark') }}</textarea>
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.liveClass.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.liveClass.fields.photo_helper') }}</span>
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
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.live-classes.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($liveClass) && $liveClass->photo)
      var file = {!! json_encode($liveClass->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
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