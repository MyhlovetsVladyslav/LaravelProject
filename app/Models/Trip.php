<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'transport_id',
        'departure_time',
        'arrival_time'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }
}
