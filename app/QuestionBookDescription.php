<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionBookDescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description'
    ];
}
