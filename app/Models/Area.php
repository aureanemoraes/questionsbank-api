<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    // Relacionamentos
    public function topics() {
        return $this->hasMany('App\Models\Topic');
    }

    public function questions() {
        return $this->hasMany('App\Models\Question');
    }
}
