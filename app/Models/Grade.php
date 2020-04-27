<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    //protected $hidden = ['slug', 'created_at', 'updated_at'];

    // Relacionamentos
    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
}
