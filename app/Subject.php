<?php

namespace App;

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
        return $this->belongsTo('App\Grade');
    }

    public function topics()
    {
        return $this->hasMany('App\Topic');
    }
}
