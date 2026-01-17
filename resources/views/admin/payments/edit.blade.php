@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.payment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payments.update", [$payment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="batch_student_id">{{ trans('cruds.payment.fields.batch_student') }}</label>
                <select class="form-control select2 {{ $errors->has('batch_student') ? 'is-invalid' : '' }}" name="batch_student_id" id="batch_student_id">
                    @foreach($batch_students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('batch_student_id') ? old('batch_student_id') : $payment->batch_student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('batch_student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('batch_student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.batch_student_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.payment.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_date">{{ trans('cruds.payment.fields.payment_date') }}</label>
                <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date', $payment->payment_date) }}">
                @if($errors->has('payment_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.payment_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.payment.fields.payment_mode') }}</label>
                <select class="form-control {{ $errors->has('payment_mode') ? 'is-invalid' : '' }}" name="payment_mode" id="payment_mode">
                    <option value disabled {{ old('payment_mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Payment::PAYMENT_MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('payment_mode', $payment->payment_mode) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment_mode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_mode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.payment_mode_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.payment.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Payment::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $payment->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="month">{{ trans('cruds.payment.fields.month') }}</label>
                <input class="form-control {{ $errors->has('month') ? 'is-invalid' : '' }}" type="text" name="month" id="month" value="{{ old('month', $payment->month) }}">
                @if($errors->has('month'))
                    <div class="invalid-feedback">
                        {{ $errors->first('month') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.month_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transaction">{{ trans('cruds.payment.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('transaction') ? 'is-invalid' : '' }}" type="text" name="transaction" id="transaction" value="{{ old('transaction', $payment->transaction) }}">
                @if($errors->has('transaction'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transaction') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.payment.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $payment->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payment.fields.remarks_helper') }}</span>
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