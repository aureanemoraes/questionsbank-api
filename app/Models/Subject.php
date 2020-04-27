<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'grade_id'
    ];

    //protected $hidden = ['slug', 'created_at', 'updated_at'];

    // Relacionamentos
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade');
    }

    public function topics()
    {
        return $this->hasMany('App\Models\Topic');
    }
}
