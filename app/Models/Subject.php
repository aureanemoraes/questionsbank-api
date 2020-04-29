<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    //protected $hidden = ['slug', 'created_at', 'updated_at'];

    // Relacionamentos
    public function topics()
    {
        return $this->hasMany('App\Models\Topic');
    }
}
