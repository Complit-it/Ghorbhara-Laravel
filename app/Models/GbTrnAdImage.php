<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnAdImage extends Model
{
    use HasFactory;

    protected $table = 'gb_trn_ad_images';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'ad_id',
        'image_path',
        'is_main'
    ];

    /**
     * Get the ad that owns the image.
     */
    public function ad()
    {
        return $this->belongsTo(GbTrnAd::class, 'ad_id');
    }

    
}
