<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type'
    ];

    public function transport()
    {
        return $this->morphOne(Transport::class, 'transportable');
    }
    public function seats()
    {
        return $this->hasManyThrough(
            TrainSeat::class,
            TrainCarriage::class,
            'train_id',
            'carriage_id',
            'id',
            'id'
        )->select('train_seats.*', 'train_carriages.type as carriage_type','train_carriages.number as carriage_number');
    }

    protected static function booted()
    {
        static::deleting(function ($train) {
            $carriages = TrainCarriage::where('train_id', $train->id)->get();

            foreach ($carriages as $carriage) {
                $carriage->delete();
            }
        });
    }
}
