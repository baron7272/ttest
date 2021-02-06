<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    // use HasFactory;
    protected $guarded  = [];
 

    public function user()
{
    return $this->belongsTo(\App\User::class, 'userIds');
}
}