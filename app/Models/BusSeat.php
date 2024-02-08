<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'seat_number'
    ];
    public function seat()
    {
        return $this->morphOne(Seat::class, 'seatable');
    }
}
