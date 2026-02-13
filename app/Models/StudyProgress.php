<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgress extends Model
{
    protected $table = 'study_progress';

    protected $fillable = [
        'study_material_id',
        'student_id',
        'is_completed',
        'completed_at'
    ];

    public function material()
    {
        return $this->belongsTo(StudyMaterial::class, 'study_material_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
