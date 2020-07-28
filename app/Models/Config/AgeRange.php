<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class AgeRange extends Model
{
    protected $fillable = ['age_range', 'age_disparity', 'min_age', 'max_age'];
}
