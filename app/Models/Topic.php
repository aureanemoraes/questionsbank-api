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
        'grade_id'
    ];

    protected $hidden = [
        'subject_id',
        'grade_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relacionamentos
    public function subject() {
        return $this->belongsTo('App\Models\Subject');
    }

    public function grade() {
        return $this->belongsTo('App\Models\Grade');
    }

}
