<?php

namespace App\Models;

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
        'teacher_user_id',
        'area_id'
    ];

    // Relacionamentos
    public function questionDescription()
    {
        return $this->belongsTo('App\Models\QuestionDescription');
    }

    public function answerType()
    {
        return $this->belongsTo('App\Models\AnswerType');
    }

    public function questionLevel()
    {
        return $this->belongsTo('App\Models\QuestionLevel');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function area() {
        return $this->belongsTo('App\Models\Area');
    }
}
