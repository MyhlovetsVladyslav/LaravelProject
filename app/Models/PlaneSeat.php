<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaneSeat extends Model
{
    use HasFactory;

    public function seat()
    {
        return $this->morphOne(Seat::class, 'seatable');
    }
}
