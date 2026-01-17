<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchStudent extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'batch_students';

    protected $dates = [
        'joining_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'   => 'Active',
        'left'     => 'Left',
        'complete' => 'Complete',
    ];

    protected $fillable = [
        'batch_id',
        'student_id',
        'joining_date',
        'status',
        'discount',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function getJoiningDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

 



public function attendances()
{
    return $this->hasMany(Attendance::class, 'batch_student_id');
}

public function payments()
{
    return $this->hasMany(Payment::class, 'batch_student_id');
}

public function testAttempts()
{
    return $this->hasMany(
        \App\Models\TestAttempt::class,
        'batch_student_id'
    );
}



}
