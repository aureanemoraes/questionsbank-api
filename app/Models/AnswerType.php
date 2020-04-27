<?php

namespace App\Models;

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
        return $this->hasMany('App\Models\Question');
    }
}
