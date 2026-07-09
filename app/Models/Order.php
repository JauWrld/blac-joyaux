<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'items',
        'total_fcfa',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
