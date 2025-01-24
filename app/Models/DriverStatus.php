<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverStatus extends Model
{
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
