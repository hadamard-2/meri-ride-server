<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
