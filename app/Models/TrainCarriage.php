<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainCarriage extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'number',
        'type'
    ];

    protected static function booted()
    {
        static::deleting(function ($carriage) {
            $seats = TrainSeat::where('carriage_id', $carriage->id)->get();
            foreach ($seats as $seat) {
                $seat->delete();
            }

        });
    }


}
