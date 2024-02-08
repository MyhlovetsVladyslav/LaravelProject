<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainSeat extends Model
{
    use HasFactory;
    protected $fillable = [
        'carriage_id',
        'seat_number'
    ];
    public function seat()
    {
        return $this->morphOne(Seat::class, 'seatable');
    }

    protected static function booted()
    {
        static::deleting(function ($seats) {
            $seats->seat()->each(function ($item) {
                $item->delete();
            });
        });
    }

}
