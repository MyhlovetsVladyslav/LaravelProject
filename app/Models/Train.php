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
