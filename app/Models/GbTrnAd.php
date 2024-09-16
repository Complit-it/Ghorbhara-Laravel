<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnAd extends Model
{
    use HasFactory;

    protected $table = 'gb_trn_ads';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'desc',
        'image_id',
        'active_flag',
        'from_date',
        'to_date'
    ];

    public function allImages()
    {
        return $this->hasMany(GbTrnAdImage::class, 'ad_id');
    }

    public function mainImage()
    {
        return $this->hasOne(GbTrnAdImage::class, 'ad_id')->where('is_main', 'Y');
    }
}
