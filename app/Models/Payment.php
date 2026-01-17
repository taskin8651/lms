<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'payments';

    protected $dates = [
        'payment_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'paid'    => 'Paid',
        'failed'  => 'Failed',
        'pending' => 'Pending',
    ];

    public const PAYMENT_MODE_SELECT = [
        'cash'   => 'Cash',
        'online' => 'Online',
        'upi'    => 'Upi',
        'bank'   => 'Bank',
    ];

    protected $fillable = [
        'batch_student_id',
        'amount',
        'payment_date',
        'payment_mode',
        'status',
        'month',
        'transaction',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function batch_student()
    {
        return $this->belongsTo(BatchStudent::class, 'batch_student_id');
    }

    public function getPaymentDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
