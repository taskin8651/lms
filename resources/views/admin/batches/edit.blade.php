@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.batch.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.batches.update", [$batch->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.batch.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $batch->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_level_id">{{ trans('cruds.batch.fields.class_level') }}</label>
                <select class="form-control select2 {{ $errors->has('class_level') ? 'is-invalid' : '' }}" name="class_level_id" id="class_level_id">
                    @foreach($class_levels as $id => $entry)
                        <option value="{{ $id }}" {{ (old('class_level_id') ? old('class_level_id') : $batch->class_level->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('class_level'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_level') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.class_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="subject_id">{{ trans('cruds.batch.fields.subject') }}</label>
                <select class="form-control select2 {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject_id" id="subject_id">
                    @foreach($subjects as $id => $entry)
                        <option value="{{ $id }}" {{ (old('subject_id') ? old('subject_id') : $batch->subject->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.subject_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="teacher_id">{{ trans('cruds.batch.fields.teacher') }}</label>
                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id">
                    @foreach($teachers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('teacher_id') ? old('teacher_id') : $batch->teacher->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('teacher'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teacher') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.teacher_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="academic_session_id">{{ trans('cruds.batch.fields.academic_session') }}</label>
                <select class="form-control select2 {{ $errors->has('academic_session') ? 'is-invalid' : '' }}" name="academic_session_id" id="academic_session_id">
                    @foreach($academic_sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('academic_session_id') ? old('academic_session_id') : $batch->academic_session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('academic_session'))
                    <div class="invalid-feedback">
                        {{ $errors->first('academic_session') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.academic_session_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="timing">{{ trans('cruds.batch.fields.timing') }}</label>
                <input class="form-control {{ $errors->has('timing') ? 'is-invalid' : '' }}" type="text" name="timing" id="timing" value="{{ old('timing', $batch->timing) }}">
                @if($errors->has('timing'))
                    <div class="invalid-feedback">
                        {{ $errors->first('timing') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.timing_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fees_amount">{{ trans('cruds.batch.fields.fees_amount') }}</label>
                <input class="form-control {{ $errors->has('fees_amount') ? 'is-invalid' : '' }}" type="text" name="fees_amount" id="fees_amount" value="{{ old('fees_amount', $batch->fees_amount) }}">
                @if($errors->has('fees_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fees_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.fees_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.batch.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Batch::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $batch->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batch.fields.status_helper') }}</span>
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