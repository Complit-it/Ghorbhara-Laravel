<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnPropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'prop_id',
        'image_path',
        'is_main',
      
    ];

    public function property()
    {
        return $this->belongsTo(GbTrnProperty::class);
    }
}
