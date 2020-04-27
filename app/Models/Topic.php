<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'subject_id',
        'area_id'
    ];

    // Relacionamentos
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function area() {
        return $this->belongsTo('App\Models\Area');
    }
}
