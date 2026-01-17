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

class LiveClass extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'live_classes';

    protected $appends = [
        'photo',
    ];

    public const STATUS_SELECT = [
        'active'    => 'Active',
        'in_active' => 'In Active',
    ];

    protected $dates = [
        'class_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const CLASS_TYPE_SELECT = [
        'custom'       => 'CUSTOM',
        'google_meet'  => 'GOOGLE_MEET',
        'youtube_live' => 'YOUTUBE_LIVE',
    ];

    protected $fillable = [
        'batch_id',
        'teacher_id',
        'class_date',
        'start_time',
        'end_time',
        'class_type',
        'meeting_link',
        'topic',
        'description',
        'recording_link',
        'status',
        'remark',
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

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function getClassDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setClassDateAttribute($value)
    {
        $this->attributes['class_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
}
