<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class GenderAgeDisparity extends Model
{
    protected $fillable = ['name', 'value', 'photo', 'gender', 'age_disparity'];
}
