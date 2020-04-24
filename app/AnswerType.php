<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    // Relacionamentos
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
