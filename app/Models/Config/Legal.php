<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Legal extends Model
{
    protected $fillable = ['name', 'title', 'content', 'version'];

    public function getContentAttribute($value)
    {
      return  $this->attributes['content'] = str_replace("\n", '', $value);
    }
}
