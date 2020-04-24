<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cpf',
        'isValid'
    ];

    // Relacionamentos
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
