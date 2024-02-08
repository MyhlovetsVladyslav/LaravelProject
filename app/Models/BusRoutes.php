<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusRoutes extends Model
{
    use HasFactory;
    protected $fillable = [
        'departure_location',
        'arrival_location',
        'distance',
        'duration'
    ];
    public function route()
    {
        return $this->morphOne(Route::class, 'routable');
    }
}
