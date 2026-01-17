@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.attendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.attendances.update", [$attendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="batch_student_id">{{ trans('cruds.attendance.fields.batch_student') }}</label>
                <select class="form-control select2 {{ $errors->has('batch_student') ? 'is-invalid' : '' }}" name="batch_student_id" id="batch_student_id">
                    @foreach($batch_students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('batch_student_id') ? old('batch_student_id') : $attendance->batch_student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('batch_student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('batch_student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.batch_student_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attendance_date">{{ trans('cruds.attendance.fields.attendance_date') }}</label>
                <input class="form-control datetime {{ $errors->has('attendance_date') ? 'is-invalid' : '' }}" type="text" name="attendance_date" id="attendance_date" value="{{ old('attendance_date', $attendance->attendance_date) }}">
                @if($errors->has('attendance_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attendance_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.attendance_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_in_time">{{ trans('cruds.attendance.fields.punch_in_time') }}</label>
                <input class="form-control datetime {{ $errors->has('punch_in_time') ? 'is-invalid' : '' }}" type="text" name="punch_in_time" id="punch_in_time" value="{{ old('punch_in_time', $attendance->punch_in_time) }}">
                @if($errors->has('punch_in_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_in_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_in_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_out_time">{{ trans('cruds.attendance.fields.punch_out_time') }}</label>
                <input class="form-control datetime {{ $errors->has('punch_out_time') ? 'is-invalid' : '' }}" type="text" name="punch_out_time" id="punch_out_time" value="{{ old('punch_out_time', $attendance->punch_out_time) }}">
                @if($errors->has('punch_out_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_out_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_out_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.attendance.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Attendance::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $attendance->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_in_image">{{ trans('cruds.attendance.fields.punch_in_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('punch_in_image') ? 'is-invalid' : '' }}" id="punch_in_image-dropzone">
                </div>
                @if($errors->has('punch_in_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_in_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_in_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_out_image">{{ trans('cruds.attendance.fields.punch_out_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('punch_out_image') ? 'is-invalid' : '' }}" id="punch_out_image-dropzone">
                </div>
                @if($errors->has('punch_out_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_out_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_out_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_in_lat">{{ trans('cruds.attendance.fields.punch_in_lat') }}</label>
                <input class="form-control {{ $errors->has('punch_in_lat') ? 'is-invalid' : '' }}" type="text" name="punch_in_lat" id="punch_in_lat" value="{{ old('punch_in_lat', $attendance->punch_in_lat) }}">
                @if($errors->has('punch_in_lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_in_lat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_in_lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_in_lng">{{ trans('cruds.attendance.fields.punch_in_lng') }}</label>
                <input class="form-control {{ $errors->has('punch_in_lng') ? 'is-invalid' : '' }}" type="text" name="punch_in_lng" id="punch_in_lng" value="{{ old('punch_in_lng', $attendance->punch_in_lng) }}">
                @if($errors->has('punch_in_lng'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_in_lng') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_in_lng_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_in_location">{{ trans('cruds.attendance.fields.punch_in_location') }}</label>
                <textarea class="form-control {{ $errors->has('punch_in_location') ? 'is-invalid' : '' }}" name="punch_in_location" id="punch_in_location">{{ old('punch_in_location', $attendance->punch_in_location) }}</textarea>
                @if($errors->has('punch_in_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_in_location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_in_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_out_lat">{{ trans('cruds.attendance.fields.punch_out_lat') }}</label>
                <input class="form-control {{ $errors->has('punch_out_lat') ? 'is-invalid' : '' }}" type="text" name="punch_out_lat" id="punch_out_lat" value="{{ old('punch_out_lat', $attendance->punch_out_lat) }}">
                @if($errors->has('punch_out_lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_out_lat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_out_lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_out_lng">{{ trans('cruds.attendance.fields.punch_out_lng') }}</label>
                <input class="form-control {{ $errors->has('punch_out_lng') ? 'is-invalid' : '' }}" type="text" name="punch_out_lng" id="punch_out_lng" value="{{ old('punch_out_lng', $attendance->punch_out_lng) }}">
                @if($errors->has('punch_out_lng'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_out_lng') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_out_lng_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punch_out_loc">{{ trans('cruds.attendance.fields.punch_out_loc') }}</label>
                <textarea class="form-control {{ $errors->has('punch_out_loc') ? 'is-invalid' : '' }}" name="punch_out_loc" id="punch_out_loc">{{ old('punch_out_loc', $attendance->punch_out_loc) }}</textarea>
                @if($errors->has('punch_out_loc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punch_out_loc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.punch_out_loc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marked_by_id">{{ trans('cruds.attendance.fields.marked_by') }}</label>
                <select class="form-control select2 {{ $errors->has('marked_by') ? 'is-invalid' : '' }}" name="marked_by_id" id="marked_by_id">
                    @foreach($marked_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('marked_by_id') ? old('marked_by_id') : $attendance->marked_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('marked_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marked_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.marked_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.attendance.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $attendance->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendance.fields.remarks_helper') }}</span>
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
    Dropzone.options.punchInImageDropzone = {
    url: '{{ route('admin.attendances.storeMedia') }}',
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
      $('form').find('input[name="punch_in_image"]').remove()
      $('form').append('<input type="hidden" name="punch_in_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="punch_in_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($attendance) && $attendance->punch_in_image)
      var file = {!! json_encode($attendance->punch_in_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="punch_in_image" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.punchOutImageDropzone = {
    url: '{{ route('admin.attendances.storeMedia') }}',
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
      $('form').find('input[name="punch_out_image"]').remove()
      $('form').append('<input type="hidden" name="punch_out_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="punch_out_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($attendance) && $attendance->punch_out_image)
      var file = {!! json_encode($attendance->punch_out_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="punch_out_image" value="' + file.file_name + '">')
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