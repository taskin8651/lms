@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.chapter.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.chapters.update", [$chapter->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="subject_id">{{ trans('cruds.chapter.fields.subject') }}</label>
                <select class="form-control select2 {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject_id" id="subject_id">
                    @foreach($subjects as $id => $entry)
                        <option value="{{ $id }}" {{ (old('subject_id') ? old('subject_id') : $chapter->subject->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.chapter.fields.subject_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.chapter.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $chapter->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.chapter.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_level">{{ trans('cruds.chapter.fields.class_level') }}</label>
                <input class="form-control {{ $errors->has('class_level') ? 'is-invalid' : '' }}" type="text" name="class_level" id="class_level" value="{{ old('class_level', $chapter->class_level) }}">
                @if($errors->has('class_level'))
                    <div class="invalid-feedback">
                        {{ $errors->first('class_level') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.chapter.fields.class_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="order_no">{{ trans('cruds.chapter.fields.order_no') }}</label>
                <input class="form-control {{ $errors->has('order_no') ? 'is-invalid' : '' }}" type="text" name="order_no" id="order_no" value="{{ old('order_no', $chapter->order_no) }}">
                @if($errors->has('order_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.chapter.fields.order_no_helper') }}</span>
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