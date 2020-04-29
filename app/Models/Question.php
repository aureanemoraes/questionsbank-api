<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'answer_type_id',
        'question_level_id',
        'user_cpf',
        'area_id'
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y',
    ];

    // Relacionamentos
    public function questionDescription()
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
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_cpf', 'cpf');
    }
    public function area() {
        return $this->belongsTo('App\Models\Area');
    }
}
