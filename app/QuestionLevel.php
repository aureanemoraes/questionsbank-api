<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionLevel extends Model
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
