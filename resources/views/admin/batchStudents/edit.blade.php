@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.batchStudent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.batch-students.update", [$batchStudent->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="batch_id">{{ trans('cruds.batchStudent.fields.batch') }}</label>
                <select class="form-control select2 {{ $errors->has('batch') ? 'is-invalid' : '' }}" name="batch_id" id="batch_id">
                    @foreach($batches as $id => $entry)
                        <option value="{{ $id }}" {{ (old('batch_id') ? old('batch_id') : $batchStudent->batch->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('batch'))
                    <div class="invalid-feedback">
                        {{ $errors->first('batch') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.batch_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="student_id">{{ trans('cruds.batchStudent.fields.student') }}</label>
                <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id">
                    @foreach($students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $batchStudent->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.student_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="joining_date">{{ trans('cruds.batchStudent.fields.joining_date') }}</label>
                <input class="form-control datetime {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="text" name="joining_date" id="joining_date" value="{{ old('joining_date', $batchStudent->joining_date) }}">
                @if($errors->has('joining_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('joining_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.joining_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.batchStudent.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BatchStudent::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $batchStudent->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount">{{ trans('cruds.batchStudent.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="text" name="discount" id="discount" value="{{ old('discount', $batchStudent->discount) }}">
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.discount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.batchStudent.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $batchStudent->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.batchStudent.fields.remarks_helper') }}</span>
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