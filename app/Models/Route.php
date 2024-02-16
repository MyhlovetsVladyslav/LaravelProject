<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
      'type'
    ];

    public function routable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::deleting(function ($route) {
            $route->routable()->each(function ($item) {
                $item->delete();
            });
        });
    }
}
