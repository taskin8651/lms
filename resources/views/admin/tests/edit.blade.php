@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.test.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tests.update", [$test->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="batch_id">{{ trans('cruds.test.fields.batch') }}</label>
                <select class="form-control select2 {{ $errors->has('batch') ? 'is-invalid' : '' }}" name="batch_id" id="batch_id">
                    @foreach($batches as $id => $entry)
                        <option value="{{ $id }}" {{ (old('batch_id') ? old('batch_id') : $test->batch->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('batch'))
                    <div class="invalid-feedback">
                        {{ $errors->first('batch') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.batch_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="subject_id">{{ trans('cruds.test.fields.subject') }}</label>
                <select class="form-control select2 {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject_id" id="subject_id">
                    @foreach($subjects as $id => $entry)
                        <option value="{{ $id }}" {{ (old('subject_id') ? old('subject_id') : $test->subject->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.subject_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.test.fields.test_type') }}</label>
                <select class="form-control {{ $errors->has('test_type') ? 'is-invalid' : '' }}" name="test_type" id="test_type">
                    <option value disabled {{ old('test_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Test::TEST_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('test_type', $test->test_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('test_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('test_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.test_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_marks">{{ trans('cruds.test.fields.total_marks') }}</label>
                <input class="form-control {{ $errors->has('total_marks') ? 'is-invalid' : '' }}" type="text" name="total_marks" id="total_marks" value="{{ old('total_marks', $test->total_marks) }}">
                @if($errors->has('total_marks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_marks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.total_marks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.test.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $test->duration) }}">
                @if($errors->has('duration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.test.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.test.fields.photo_helper') }}</span>
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
    url: '{{ route('admin.tests.storeMedia') }}',
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
@if(isset($test) && $test->photo)
      var file = {!! json_encode($test->photo) !!}
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