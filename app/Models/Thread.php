<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/threads/'.$this->id;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
