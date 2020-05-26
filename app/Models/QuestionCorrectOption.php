<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCorrectOption extends Model
{
    protected $table = 'question_correct_options';

    protected $fillable = [
        'question_id',
        'option_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'question_id'
    ];

    // Relacionamentos
    //public function questions()
    //{
    //    return $this->belongsToMany('App\Models\Question');
    //}
//
    //public function options()
    //{
    //    return $this->belongsToMany('App\Models\Option');
    //}
}
