<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $fillable = ['name', 'value', 'gender', 'age_disparity'];
}
