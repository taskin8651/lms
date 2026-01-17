<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Test extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'tests';

    protected $appends = [
        'photo',
        'questions_count',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Test Types
     */
    public const TEST_TYPE_SELECT = [
        'class' => 'Class Test',
        'unit'  => 'Unit Test',
        'mock'  => 'Mock Test',
    ];

    /**
     * Test Modes
     * exam = real test
     * practice = unlimited attempts
     */
    public const MODE_SELECT = [
        'exam'     => 'Exam',
        'practice' => 'Practice',
    ];

    protected $fillable = [
        'batch_id',
        'subject_id',
        'title',
        'test_type',
        'mode',
        'total_marks',
        'duration',
        'total_questions',
        'is_published',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    /**
     * Relationships
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }

    public function attempts()
{
    return $this->hasMany(\App\Models\TestAttempt::class, 'test_id');
}


    /**
     * Helpers (VERY USEFUL)
     */
    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }

    public function isPublished(): bool
    {
        return (bool) $this->is_published;
    }

    public function isPractice(): bool
    {
        return $this->mode === 'practice';
    }

    public function isExam(): bool
    {
        return $this->mode === 'exam';
    }

    /**
     * Media Accessor
     */
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
