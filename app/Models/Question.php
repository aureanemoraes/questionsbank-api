<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'answer_type_id',
        'question_level_id',
        'teacher_id',
        'optionsTitles',
        'correctOption'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'answer_type_id',
        'question_level_id',
        'teacher_id',
        'correctOption'
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y',
    ];

    // Relacionamentos
    public function description()
    {
        return $this->hasOne('App\Models\QuestionDescription');
    }

    public function answerType()
    {
        return $this->belongsTo('App\Models\AnswerType');
    }

    public function questionLevel()
    {
        return $this->belongsTo('App\Models\QuestionLevel');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id', 'id');
    }
    public function areas() {
        return $this->hasMany('App\Models\AreasQuestion');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }

    public function correctOption()
    {
        return $this->hasMany('App\Models\QuestionCorrectOption');
    }

    public function topics()
    {
        return $this->hasMany('App\Models\TopicsQuestion');
    }
}
