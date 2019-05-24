<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];
    protected $guarded = [];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }
}
