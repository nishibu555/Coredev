<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    protected $fillable = ['name', 'value', 'date'];

    protected $dates = ['date'];
}
