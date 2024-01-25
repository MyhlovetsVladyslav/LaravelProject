<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Plane extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
    ];

    public function transport()
    {
        return $this->morphOne(Transport::class, 'transportable');
    }
}
