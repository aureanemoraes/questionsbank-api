<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'question_description_id',
        'answer_type_id',
        'question_level_id',
        'teacher_user_id'
    ];

    // Relacionamentos
    public function questionDescription()
    {
        return $this->belongsTo('App\QuestionDescription');
    }

    public function answerType()
    {
        return $this->belongsTo('App\AnswerType');
    }

    public function questionLevel()
    {
        return $this->belongsTo('App\QuestionLevel');
    }
    public function teacherUser()
    {
        return $this->belongsTo('App\TeacherUser', 'foreign_key', 'other_key');
    }
}
