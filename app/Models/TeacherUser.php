<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cpf',
        'name',
        'isValid'
    ];

    // Relacionamentos
    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }
}
