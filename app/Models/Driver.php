<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function documents()
    {
        return $this->hasOne(DriverDocument::class);
    }

    public function status()
    {
        return $this->hasOne(DriverStatus::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
