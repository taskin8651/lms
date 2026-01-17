<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Attendance extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'attendances';

    protected $appends = [
        'punch_in_image',
        'punch_out_image',
    ];

    public const STATUS_SELECT = [
        'present' => 'present',
        'partial' => 'Partial',
        'absent'  => 'Absent',
    ];

    protected $dates = [
        'attendance_date',
        'punch_in_time',
        'punch_out_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'batch_student_id',
        'attendance_date',
        'punch_in_time',
        'punch_out_time',
        'status',
        'punch_in_lat',
        'punch_in_lng',
        'punch_in_location',
        'punch_out_lat',
        'punch_out_lng',
        'punch_out_loc',
        'marked_by_id',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function batch_student()
    {
        return $this->belongsTo(BatchStudent::class, 'batch_student_id');
    }

    public function getAttendanceDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setAttendanceDateAttribute($value)
    {
        $this->attributes['attendance_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPunchInTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPunchInTimeAttribute($value)
    {
        $this->attributes['punch_in_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPunchOutTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPunchOutTimeAttribute($value)
    {
        $this->attributes['punch_out_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getPunchInImageAttribute()
    {
        $file = $this->getMedia('punch_in_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getPunchOutImageAttribute()
    {
        $file = $this->getMedia('punch_out_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function marked_by()
    {
        return $this->belongsTo(Teacher::class, 'marked_by_id');
    }

    
}
