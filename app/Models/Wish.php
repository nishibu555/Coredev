<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = array('user_id', 'product_id', 'title', 'status');

    public  function  user()
    {
        return $this->belongsTo(User::class);
    }
}
