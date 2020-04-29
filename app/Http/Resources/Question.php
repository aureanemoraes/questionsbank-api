<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Question extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
