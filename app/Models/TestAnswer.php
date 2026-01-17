<?php

namespace App\Models;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'selected_option',
        'is_correct',
        'marks_obtained'
    ];

    public function attempt()
    {
        return $this->belongsTo(TestAttempt::class, 'test_attempt_id');
    }

    public function question()
{
    return $this->belongsTo(Question::class, 'question_id');
}
}

