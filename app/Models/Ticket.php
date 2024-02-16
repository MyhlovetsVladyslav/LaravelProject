<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',
        'seat_id',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}
