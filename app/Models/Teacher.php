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

class Teacher extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    protected $table = 'teachers';

    /* =========================
     |  APPENDS (MEDIA)
     ========================= */
    protected $appends = [
        'profile',
        'document',
    ];

    /* =========================
     |  STATUS
     ========================= */
    public const STATUS_SELECT = [
        'active'    => 'Active',
        'in_active' => 'In Active',
    ];

    /* =========================
     |  DATES
     ========================= */
    protected $dates = [
        'joining_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /* =========================
     |  FILLABLE
     ========================= */
    protected $fillable = [
        'user_id',
        'mobile',
        'subject',
        'experience',
        'joining_date',
        'salary',
        'status',
    ];

    /* =========================
     |  DATE FORMAT
     ========================= */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /* =========================
     |  MEDIA CONVERSIONS
     ========================= */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    /* =========================
     |  RELATIONSHIPS
     ========================= */

    // Login user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Teacher → Batches
    public function batches()
    {
        return $this->hasMany(Batch::class, 'teacher_id');
    }

    // Teacher → Attendances marked by him
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }

    // Teacher → Live Classes
    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class, 'teacher_id');
    }

    // Teacher → Tests
    public function tests()
    {
        return $this->hasMany(Test::class, 'teacher_id');
    }

    /* =========================
     |  ACCESSORS & MUTATORS
     ========================= */

    // Joining date (show format)
    public function getJoiningDateAttribute($value)
    {
        return $value
            ? Carbon::parse($value)->format(config('panel.date_format'))
            : null;
    }

    // Joining date (save format)
    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = $value
            ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d')
            : null;
    }

    /* =========================
     |  MEDIA ACCESSORS
     ========================= */

    // Profile photo
    public function getProfileAttribute()
    {
        $file = $this->getMedia('profile')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    // Documents (certificates, ID, etc.)
    public function getDocumentAttribute()
    {
        $files = $this->getMedia('document');

        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
