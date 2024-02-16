<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    public function transportable()
    {
        return $this->morphTo();
    }



    protected static function booted()
    {
        static::deleting(function ($transport) {
            $transport->transportable()->each(function ($item) {
                $item->delete();
            });
        });
    }
}
