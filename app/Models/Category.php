<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }
}
