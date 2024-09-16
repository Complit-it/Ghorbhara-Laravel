<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;
    protected $fillable = [
        'imageUrl',
        'scheduledfrom',
        'scheduledto',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'status',
    ];
}
