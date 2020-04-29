<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// SoftDeletes
use Illuminate\Database\Eloquent\SoftDeletes;
// Passport
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable;

    protected $fillable = [
        'cpf',
        'name',
        'email',
        'password',
        'verified_at',
        'level',
        'sigeduc_id'
    ];

    // Definindo CPF como primary key
    protected $primaryKey = 'cpf';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'password',
        'verified_at',
        'sigeduc_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    //protected $casts = [
    //    'email_verified_at' => 'datetime',
    //];

    // Relacionamentos
    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function questionbook()
    {
        return $this->hasMany('App\Models\QuestionBook');
    }
}
