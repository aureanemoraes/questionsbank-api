<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'title',
        'question_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'question_id'
    ];

    // Relacionamentos
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
