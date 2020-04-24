<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'subject_id'
    ];

    // Relacionamentos
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }


}
