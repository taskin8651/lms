<?php

namespace App\Models;
use App\Models\Test;
use App\Models\BatchStudent;
use App\Models\TestAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    protected $fillable = [
        'test_id',
        'batch_student_id',
        'attempt_no',
        'total_questions',
        'attempted',
        'correct',
        'wrong',
        'score',
        'percentage',
        'status',
        'started_at',
        'submitted_at'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function batchStudent()
{
    return $this->belongsTo(BatchStudent::class, 'batch_student_id');
}
}
