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
}
