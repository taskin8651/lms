<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Batch extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'batches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'    => 'Active',
        'in_active' => 'In Active',
    ];

    protected $fillable = [
        'name',
        'class_level_id',
        'subject_id',
        'teacher_id',
        'academic_session_id',
        'timing',
        'fees_amount',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function class_level()
    {
        return $this->belongsTo(ClassLevel::class, 'class_level_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function academic_session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function students()
{
    return $this->hasMany(BatchStudent::class, 'batch_id');
}
}
