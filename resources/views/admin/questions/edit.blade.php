@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.question.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.questions.update", [$question->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="test_id">{{ trans('cruds.question.fields.test') }}</label>
                <select class="form-control select2 {{ $errors->has('test') ? 'is-invalid' : '' }}" name="test_id" id="test_id">
                    @foreach($tests as $id => $entry)
                        <option value="{{ $id }}" {{ (old('test_id') ? old('test_id') : $question->test->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('test'))
                    <div class="invalid-feedback">
                        {{ $errors->first('test') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.test_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="question">{{ trans('cruds.question.fields.question') }}</label>
                <textarea class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question" id="question">{{ old('question', $question->question) }}</textarea>
                @if($errors->has('question'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.question_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_a">{{ trans('cruds.question.fields.option_a') }}</label>
                <input class="form-control {{ $errors->has('option_a') ? 'is-invalid' : '' }}" type="text" name="option_a" id="option_a" value="{{ old('option_a', $question->option_a) }}">
                @if($errors->has('option_a'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_a') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.option_a_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_b">{{ trans('cruds.question.fields.option_b') }}</label>
                <input class="form-control {{ $errors->has('option_b') ? 'is-invalid' : '' }}" type="text" name="option_b" id="option_b" value="{{ old('option_b', $question->option_b) }}">
                @if($errors->has('option_b'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_b') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.option_b_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_c">{{ trans('cruds.question.fields.option_c') }}</label>
                <input class="form-control {{ $errors->has('option_c') ? 'is-invalid' : '' }}" type="text" name="option_c" id="option_c" value="{{ old('option_c', $question->option_c) }}">
                @if($errors->has('option_c'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_c') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.option_c_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_d">{{ trans('cruds.question.fields.option_d') }}</label>
                <input class="form-control {{ $errors->has('option_d') ? 'is-invalid' : '' }}" type="text" name="option_d" id="option_d" value="{{ old('option_d', $question->option_d) }}">
                @if($errors->has('option_d'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_d') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.option_d_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="correct_option">{{ trans('cruds.question.fields.correct_option') }}</label>
                <input class="form-control {{ $errors->has('correct_option') ? 'is-invalid' : '' }}" type="text" name="correct_option" id="correct_option" value="{{ old('correct_option', $question->correct_option) }}">
                @if($errors->has('correct_option'))
                    <div class="invalid-feedback">
                        {{ $errors->first('correct_option') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.correct_option_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marks">{{ trans('cruds.question.fields.marks') }}</label>
                <input class="form-control {{ $errors->has('marks') ? 'is-invalid' : '' }}" type="text" name="marks" id="marks" value="{{ old('marks', $question->marks) }}">
                @if($errors->has('marks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.marks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="negative_marks">{{ trans('cruds.question.fields.negative_marks') }}</label>
                <input class="form-control {{ $errors->has('negative_marks') ? 'is-invalid' : '' }}" type="text" name="negative_marks" id="negative_marks" value="{{ old('negative_marks', $question->negative_marks) }}">
                @if($errors->has('negative_marks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('negative_marks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.negative_marks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.question.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="explanation">{{ trans('cruds.question.fields.explanation') }}</label>
                <textarea class="form-control {{ $errors->has('explanation') ? 'is-invalid' : '' }}" name="explanation" id="explanation">{{ old('explanation', $question->explanation) }}</textarea>
                @if($errors->has('explanation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('explanation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.question.fields.explanation_helper') }}</span>
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
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.questions.storeMedia') }}',
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
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($question) && $question->image)
      var file = {!! json_encode($question->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
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