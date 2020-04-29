<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionBookDescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relacionamentos
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
